<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Penitipan Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .label { font-weight: bold; width: 160px; display: inline-block; vertical-align: top; }
        .value { display: inline-block; }
        .images-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .images-row img {
            width: 30%;
            max-height: 120px;
            object-fit: cover;
            border: 1px solid #ccc;
            padding: 3px;
            border-radius: 4px;
        }
        .thumbnail img {
            max-height: 160px;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 4px;
        }
        hr {
            margin: 15px 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Nota Penitipan Barang</h2>
        <p>ReuseMart - Pegawai Gudang</p>
        <hr>
    </div>

    <div class="section">
        <span class="label">Nama Barang:</span> <span class="value">{{ $barang->nama }}</span><br>
        <span class="label">Kategori:</span> <span class="value">{{ $barang->kategori->nama ?? '-' }}</span><br>
        <span class="label">Harga:</span> <span class="value">Rp{{ number_format($barang->harga, 0, ',', '.') }}</span><br>
        <span class="label">Deskripsi:</span> <span class="value">{{ $barang->deskripsi }}</span>
    </div>

    <div class="section">
        <span class="label">Penitip:</span> <span class="value">{{ $barang->penitip->username }}</span><br>
        <span class="label">Tanggal Titip:</span> <span class="value">{{ $barang->created_at->format('d M Y') }}</span><br>
        <span class="label">Batas Titip:</span> <span class="value">{{ $barang->batas_waktu_titip->format('d M Y') }}</span><br>
        <span class="label">Diterima oleh:</span> <span class="value">{{ $barang->qualityChecker->nama_lengkap ?? '-' }}</span>
    </div>

    <div class="section thumbnail">
        <span class="label">Thumbnail Barang:</span><br>
        <img src="{{ public_path('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}" alt="Thumbnail">
    </div>

    <div class="section thumbnail">
        <span class="label">Foto Lain:</span>
    </div>

    <div class="section">
        @php
            $fotoLain = json_decode($barang->foto_lain, true);
        @endphp

        @if (is_array($fotoLain) && count($fotoLain))
            <div class="images-row">
                @foreach ($fotoLain as $foto)
                    <img src="{{ public_path('images/barang/' . $barang->id . '/' . $foto) }}" alt="Foto Lain">
                @endforeach
            </div>
        @else
            <p style="color: gray;">Tidak ada foto tambahan</p>
        @endif
    </div>

</body>
</html>
