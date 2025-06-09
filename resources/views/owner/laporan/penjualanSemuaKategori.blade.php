<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan Semua Kategori</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 12px; 
            margin: 20px;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        h2 { 
            margin-top: 40px; 
            color: #555;
            background-color: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #007bff;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            margin-bottom: 20px;
        }
        
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        
        .total-row {
            background-color: #e9f4ff;
            font-weight: bold;
        }
        
        .grand-total {
            background-color: #d4edda;
            font-weight: bold;
            font-size: 14px;
        }
        
        .price-cell {
            text-align: right;
        }
        
        .summary-table {
            margin-top: 30px;
            border: 2px solid #333;
        }
        
        .summary-table th {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Laporan Penjualan Semua Kategori</h1>
    
    @php
        $grandTotal = 0;
        $totalItemsPerKategori = [];
    @endphp
    
    @foreach($data as $kategori => $barangs)
        @php
            $totalKategori = 0;
            $jumlahItem = count($barangs);
        @endphp
        
        <h2>Kategori: {{ $kategori }} ({{ $jumlahItem }} item)</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Penitip</th>
                    <th>Tanggal Terjual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $index => $barang)
                    @php
                        $totalKategori += $barang->harga;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $barang->nama }}</td>
                        <td class="price-cell">Rp{{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td>{{ $barang->penitip->username ?? '-' }}</td>
                        <td>{{ $barang->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2"><strong>Total {{ $kategori }}</strong></td>
                    <td class="price-cell"><strong>Rp{{ number_format($totalKategori, 0, ',', '.') }}</strong></td>
                    <td colspan="2"><strong>{{ $jumlahItem }} item</strong></td>
                </tr>
            </tbody>
        </table>
        
        @php
            $grandTotal += $totalKategori;
            $totalItemsPerKategori[$kategori] = ['total' => $totalKategori, 'jumlah' => $jumlahItem];
        @endphp
    @endforeach
    
    <!-- Ringkasan Total -->
    <div style="margin-top: 40px;">
        <h2>Ringkasan Penjualan</h2>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Jumlah Item</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($totalItemsPerKategori as $kategori => $info)
                    <tr>
                        <td>{{ $kategori }}</td>
                        <td style="text-align: center;">{{ $info['jumlah'] }}</td>
                        <td class="price-cell">Rp{{ number_format($info['total'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="grand-total">
                    <td><strong>TOTAL KESELURUHAN</strong></td>
                    <td style="text-align: center;"><strong>{{ array_sum(array_column($totalItemsPerKategori, 'jumlah')) }}</strong></td>
                    <td class="price-cell"><strong>Rp{{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666;">
        <p>Laporan dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>