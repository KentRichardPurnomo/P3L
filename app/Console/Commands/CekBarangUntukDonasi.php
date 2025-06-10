<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Barang;
use Illuminate\Support\Carbon;

class CekBarangUntukDonasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'barang:cek-titip-donasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek barang yang melebihi 7 hari dari batas waktu titip dan ubah status menjadi "barang untuk donasi"';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();

        $barangUntukDonasi = Barang::where('status', 'tersedia')
            ->whereDate('batas_waktu_titip', '<', $today->subDays(7))
            ->get();

        foreach ($barangUntukDonasi as $barang) {
            $barang->status = 'barang untuk donasi';
            $barang->save();

            $this->info("Barang ID {$barang->id} diubah ke status 'barang untuk donasi'");
        }

        $this->info("Pengecekan selesai.");
        return 0;
    }
}
