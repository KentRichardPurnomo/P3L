<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Penitip;
use App\Models\Transaksi;
use App\Models\Pegawai;
use App\Models\JadwalPengiriman;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BarangGudangController extends Controller
{
    public function index(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();
        $query = Barang::with(['kategori', 'penitip'])
            ->where('quality_check', $pegawai->id);

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('nama', 'like', '%' . $searchTerm . '%');
        }

        $barangs = $query->get();

        return view('gudang.barangIndex', compact('barangs'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $penitips = Penitip::all();

        return view('gudang.barangCreate', compact('kategoris', 'penitips'));
    }

    public function store(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'thumbnail' => 'required|image|mimes:jpg,jpeg|max:20480',
            'foto_lain.*' => 'nullable|image|mimes:jpg,jpeg|max:20480',
            'punya_garansi' => 'required|in:0,1',
            'garansi_berlaku_hingga' => 'nullable|date',
            'penitip_id' => 'required|exists:penitips,id',
        ]);

        $garansi = $request->punya_garansi == 1 ? $request->garansi_berlaku_hingga : null;

        // 1. Simpan barang untuk dapat ID
        $barang = Barang::create([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'garansi_berlaku_hingga' => $garansi,
            'terjual' => false,
            'penitip_id' => $request->penitip_id,
            'quality_check' => $pegawai->id,
            'batas_waktu_titip' => now()->addMonth(),
            'thumbnail' => '',
            'foto_lain' => json_encode([]),
        ]);

        $id = $barang->id;
        $folder = public_path("images/barang/$id");

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0775, true);
        }

        // 2. Simpan thumbnail
        $thumbnailFile = $request->file('thumbnail');
        $thumbnailName = "{$id}.jpg";
        $thumbnailFile->move($folder, $thumbnailName);

        // 3. Simpan foto_lain[]
        $fotoLainPaths = [];
        if ($request->hasFile('foto_lain')) {
            $index = 1;
            foreach ($request->file('foto_lain') as $foto) {
                $fotoName = "{$id}_{$index}.jpg";
                $foto->move($folder, $fotoName);
                $fotoLainPaths[] = $fotoName;
                $index++;
            }
        }

        // 4. Update thumbnail dan foto_lain
        $barang->update([
            'thumbnail' => $thumbnailName,
            'foto_lain' => json_encode($fotoLainPaths),
        ]);

        // 5. Generate PDF Nota Penitipan
        $barang->load(['kategori', 'penitip']);
        $pdf = Pdf::loadView('gudang.nota_pdf', ['barang' => $barang]);

        $pdfPath = storage_path("app/public/notas/nota-barang-{$barang->id}.pdf");
        if (!File::exists(dirname($pdfPath))) {
            File::makeDirectory(dirname($pdfPath), 0755, true);
        }
        $pdf->save($pdfPath);

        return redirect()->route('gudang.barang.index')
            ->with('success', 'Barang berhasil ditambahkan dan nota penitipan telah dibuat.');
    }

    public function show($id)
    {
        $barang = Barang::with(['kategori', 'penitip'])->findOrFail($id);
        return view('gudang.barangShow', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        $penitips = Penitip::all();

        return view('gudang.barangEdit', compact('barang', 'kategoris', 'penitips'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Auth::guard('pegawai')->user();
        $barang = Barang::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg|max:20480',
            'foto_lain.*' => 'nullable|image|mimes:jpg,jpeg|max:20480',
            'punya_garansi' => 'required|in:0,1',
            'garansi_berlaku_hingga' => 'nullable|date',
            'penitip_id' => 'required|exists:penitips,id',
        ]);

        $garansi = $request->punya_garansi == 1 ? $request->garansi_berlaku_hingga : null;

        $folder = public_path("images/barang/{$barang->id}");
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0775, true);
        }

        if ($request->hasFile('thumbnail')) {
            $thumbnailName = "{$barang->id}.jpg";
            $request->file('thumbnail')->move($folder, $thumbnailName);
            $barang->thumbnail = $thumbnailName;
        }

        $fotoLainPaths = is_array(json_decode($barang->foto_lain, true)) ? json_decode($barang->foto_lain, true) : [];

        if ($request->hasFile('foto_lain')) {
            $index = count($fotoLainPaths) + 1;
            foreach ($request->file('foto_lain') as $foto) {
                $fotoName = "{$barang->id}_{$index}.jpg";
                $foto->move($folder, $fotoName);
                $fotoLainPaths[] = $fotoName;
                $index++;
            }
        }

        $barang->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'garansi_berlaku_hingga' => $garansi,
            'penitip_id' => $request->penitip_id,
            'foto_lain' => json_encode($fotoLainPaths),
        ]);

        return redirect()->route('gudang.barang.show', $barang->id)->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $folder = public_path("images/barang/{$barang->id}");
        if (File::exists($folder)) {
            File::deleteDirectory($folder);
        }

        $notaPath = storage_path("app/public/notas/nota-barang-{$barang->id}.pdf");
        if (File::exists($notaPath)) {
            File::delete($notaPath);
        }

        $barang->delete();

        return redirect()->route('gudang.barang.index')->with('success', 'Barang berhasil dihapus.');
    }

       public function formPengambilan($id)
    {
        $barang = Barang::findOrFail($id);

        // Validasi bahwa barang sudah dikonfirmasi akan diambil oleh penitip
        if ($barang->status_pengambilan !== 'dikonfirmasi') {
            return redirect()->route('gudang.barang.index')->with('error', 'Barang belum dikonfirmasi untuk diambil oleh penitip.');
        }

        return view('gudang.barang.form_ambil', compact('barang'));
    }

    public function simpanPengambilan(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        // Set status sebagai sudah diambil kembali (misal status = 1)
        $barang->diambil_kembali = 1; // diambil kembali
        $barang->tanggal_diambil_kembali = Carbon::now();
        $barang->save();

        return redirect()->route('gudang.barang.index')->with('success', 'Barang telah dicatat sebagai sudah diambil.');
    }

    public function catatPengambilan($id)
    {
        $barang = Barang::findOrFail($id);

        // Cek dulu apakah status_pengambilan sudah 1 dan status masih 0
        if ($barang->status_pengambilan == 1 && $barang->diambil_kembali == 0) {
            $barang->diambil_kembali = 1; // sudah diambil
            $barang->tanggal_diambil_kembali = now();
            $barang->save();

            return redirect()->route('gudang.barang.index')->with('success', 'Pengambilan barang berhasil dicatat.');
        }

        return redirect()->route('gudang.barang.index')->with('error', 'Barang tidak dapat dicatat pengambilannya.');
    }

        public function transaksi()
    {
        $pegawai = Auth::guard('pegawai')->user();

        // Barang yang harus dikirim
        $barangKirim = Barang::with(['transaksi.pembeli'])
            ->where('quality_check', $pegawai->id)
            ->whereHas('transaksi', function ($query) {
                $query->where('tipe_pengiriman', 'kirim');
            })
            ->get();

        // Barang yang harus diambil
        $barangAmbil = Barang::with(['transaksi.pembeli'])
            ->where('quality_check', $pegawai->id)
            ->whereHas('transaksi', function ($query) {
                $query->where('tipe_pengiriman', 'ambil');
            })
            ->get();

        return view('gudang.barangtransaksi', compact('barangKirim', 'barangAmbil'));
    }

    public function formJadwalKirim($id)
    {
        $barang = Barang::with(['transaksi', 'jadwalPengirimen.pegawai'])->findOrFail($id);
        $pegawais = Pegawai::whereHas('jabatan', function($q) {
            $q->where('nama_jabatan', 'Kurir');
        })->get();

        $jadwal = $barang->jadwalPengirimen; // relasi satu-satu

        return view('gudang.jadwal-kirim', compact('barang', 'pegawais', 'jadwal'));
    }


     public function simpanJadwalKirim(Request $request, $id)
    {
        $request->validate([
            'jadwal_kirim' => 'required|date',
            'pegawai_id' => 'required|exists:pegawais,id',
        ]);

        $barang = Barang::with('transaksi')->findOrFail($id);

        // Validasi waktu
        $jadwalTanggal = \Carbon\Carbon::parse($request->jadwal_kirim)->format('Y-m-d');
        $jadwalJam = \Carbon\Carbon::parse($request->jadwal_kirim)->format('H:i');
        $hariIni = now()->format('Y-m-d');

        if ($jadwalTanggal == $hariIni && $jadwalJam > '16:00') {
            return back()->with('error', 'Tidak bisa dijadwalkan di hari yang sama setelah jam 16:00.');
        }

        // Cek apakah sudah ada jadwal pengiriman untuk barang ini
        $jadwal = JadwalPengiriman::where('barang_id', $barang->id)->first();

        if ($jadwal) {
            // Update jadwal yang sudah ada
            $jadwal->update([
                'pegawai_id' => $request->pegawai_id,
                'jadwal_kirim' => $request->jadwal_kirim,
            ]);
        } else {
            // Buat jadwal baru
            JadwalPengiriman::create([
                'barang_id' => $barang->id,
                'pegawai_id' => $request->pegawai_id,
                'jadwal_kirim' => $request->jadwal_kirim,
            ]);
        }

        // Update status barang jika perlu
        $barang->update(['status' => 'Sedang Dikirim']);

        // Notifikasi bisa kamu implementasikan di sini sesuai kebutuhan

        return redirect()->route('gudang.barang.transaksi')->with('success', 'Jadwal pengiriman berhasil disimpan.');
    }

    public function cetakNota($id)
    {
        $barang = Barang::with(['transaksi.pembeli', 'transaksi'])->findOrFail($id);
        $pegawais = Pegawai::all();

        $pdf = Pdf::loadView('gudang.nota-pdf', compact('barang','pegawais'));
        return $pdf->download('nota_penjualan_barang_' . $barang->id . '.pdf');
    }

}
