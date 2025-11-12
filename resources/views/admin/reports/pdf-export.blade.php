<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 10px;
            color: #666;
        }
        .info {
            margin-bottom: 15px;
            font-size: 10px;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .info-label {
            width: 100px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table thead {
            background-color: #f4f4f4;
        }
        table th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
        }
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 10px;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #666;
            text-align: center;
        }
        .total-row {
            background-color: #e8e8e8;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN KUNJUNGAN</h1>
            <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}{{ $bidangName }}</p>
        </div>

        <!-- Info Section -->
        <div class="info">
            <div class="info-row">
                <span class="info-label">Total Kunjungan:</span>
                <span>{{ $guests->count() }} kunjungan</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Cetak:</span>
                <span>{{ now()->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>

        <!-- Data Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Nama</th>
                    <th style="width: 12%;">Telepon</th>
                    <th style="width: 15%;">Instansi</th>
                    <th style="width: 18%;">Keperluan</th>
                    <th style="width: 15%;">Seksi Tujuan</th>
                    <th style="width: 20%;">Jam Masuk</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $index => $guest)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $guest->nama }}</td>
                        <td>{{ $guest->telepon ?? '-' }}</td>
                        <td>{{ $guest->instansi ?? '-' }}</td>
                        <td>{{ $guest->keperluan }}</td>
                        <td>{{ $guest->bidangInfo->nama ?? '-' }}</td>
                        <td>{{ $guest->check_in_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada data kunjungan</td>
                    </tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="7" style="text-align: right;">Total: {{ $guests->count() }} Kunjungan</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini digenerate secara otomatis dari Sistem Buku Tamu</p>
            <p>{{ config('app.name', 'Buku Tamu') }} - {{ now()->format('Y') }}</p>
        </div>
    </div>
</body>
</html>
