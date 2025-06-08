<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masa Penitipan Habis</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            font-size: 12px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .company-address {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 20px;
        }
        
        .report-title {
            font-size: 16px;
            font-weight: bold;
            color: #e74c3c;
            background-color: #ffeaa7;
            padding: 10px;
            border: 2px solid #e17055;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        
        .report-date {
            font-size: 11px;
            color: #636e72;
            margin-bottom: 20px;
        }
        
        .summary-box {
            background-color: #fff5f5;
            border: 1px solid #fed7d7;
            border-left: 4px solid #e53e3e;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .summary-box h3 {
            margin: 0 0 10px 0;
            color: #e53e3e;
            font-size: 14px;
        }
        
        .summary-stats {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        
        .stat-item {
            text-align: center;
            flex: 1;
        }
        
        .stat-number {
            font-size: 16px;
            font-weight: bold;
            color: #e53e3e;
        }
        
        .stat-label {
            color: #7f8c8d;
            margin-top: 5px;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px;
            font-size: 11px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        th { 
            background-color: #2c3e50;
            color: white;
            border: 1px solid #34495e; 
            padding: 12px 8px; 
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        
        td { 
            border: 1px solid #ddd; 
            padding: 10px 8px; 
            vertical-align: middle;
            text-align: center;
        }
        
        .kode-produk {
            font-weight: bold;
            color: #2c3e50;
            background-color: #ecf0f1;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }
        
        .nama-produk {
            text-align: left;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .id-penitip {
            font-weight: bold;
            color: #3498db;
            background-color: #e3f2fd;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }
        
        .nama-penitip {
            text-align: left;
            color: #2c3e50;
        }
        
        .tanggal {
            font-size: 10px;
            color: #7f8c8d;
        }
        
        .batas-ambil {
            font-weight: bold;
            color: #e74c3c;
            background-color: #ffebee;
            padding: 4px 8px;
            border-radius: 3px;
            border: 1px solid #ffcdd2;
        }
        
        .status-expired {
            background-color: #ffebee;
        }
        
        .status-warning {
            background-color: #fff3e0;
        }
        
        /* Baris bergantian */
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .footer {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }
        
        .warning-note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-left: 4px solid #f39c12;
            padding: 10px;
            margin-top: 20px;
            border-radius: 4px;
            font-size: 11px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">ReUse Mart</div>
        <div class="company-address">Jl. Green Eco Park No. 456 Yogyakarta</div>
        
        <div class="report-title">
            LAPORAN<br>
            Barang yang Masa Penitipannya Sudah Habis
        </div>
        
        <div class="report-date">
            <strong>Tanggal cetak:</strong> {{ date('d F Y') }}
        </div>
    </div>

    @if(count($expiredBarangs) > 0)
        <div class="summary-box">
            <h3>Ringkasan Laporan</h3>
            <div class="summary-stats">
                <div class="stat-item">
                    <div class="stat-number">{{ count($expiredBarangs) }}</div>
                    <div class="stat-label">Total Barang</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $expiredBarangs->groupBy('penitip_id')->count() }}</div>
                    <div class="stat-label">Jumlah Penitip</div>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 12%;">Kode Produk</th>
                    <th style="width: 25%;">Nama Produk</th>
                    <th style="width: 10%;">Id Penitip</th>
                    <th style="width: 20%;">Nama Penitip</th>
                    <th style="width: 11%;">Tanggal Masuk</th>
                    <th style="width: 11%;">Tanggal Akhir</th>
                    <th style="width: 11%;">Batas Ambil</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expiredBarangs as $barang)
                    <tr>
                        <td>
                            <span class="kode-produk">{{ $barang->kode ?? 'K' . $barang->id }}</span>
                        </td>
                        <td class="nama-produk">
                            {{ $barang->nama }}
                            @if($barang->kategori)
                                <br><small style="color: #7f8c8d;">{{ $barang->kategori->nama }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="id-penitip">{{ $barang->penitip->kode ?? 'T' . $barang->penitip_id }}</span>
                        </td>
                        <td class="nama-penitip">
                            {{ $barang->penitip->username ?? '-' }}
                            @if($barang->penitip && $barang->penitip->nama)
                                <br><small style="color: #7f8c8d;">{{ $barang->penitip->nama }}</small>
                            @endif
                        </td>
                        <td class="tanggal">
                            {{ \Carbon\Carbon::parse($barang->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="tanggal">
                            {{ \Carbon\Carbon::parse($barang->batas_waktu_titip)->format('d/m/Y') }}
                        </td>
                        <td>
                            <span class="batas-ambil">
                                {{ \Carbon\Carbon::parse($barang->batas_waktu_titip)->addDays(7)->format('d/m/Y') }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="warning-note">
            <strong>⚠️ Catatan Penting:</strong><br>
            • Segera hubungi penitip untuk mengambil barang atau perpanjang masa penitipan<br>
            • Barang yang tidak diambil dalam waktu yang ditentukan dapat diproses sesuai kebijakan toko
        </div>
    @else
        <div class="no-data">
            <h3>✅ Tidak Ada Barang yang Masa Penitipannya Habis</h3>
            <p>Semua barang masih dalam masa penitipan yang berlaku.</p>
        </div>
    @endif

    <div class="footer">
        <p>Laporan digenerate pada {{ date('d F Y, H:i:s') }} WIB</p>
        <p>© {{ date('Y') }} ReUse Mart - Sistem Manajemen Barang Titipan</p>
        <p><em>Dokumen ini bersifat rahasia dan hanya untuk keperluan internal</em></p>
    </div>
</body>
</html>