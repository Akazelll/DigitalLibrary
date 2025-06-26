<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Peminjaman - DigiPustaka</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
        }
        .header-table, .main-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            padding: 0;
            vertical-align: middle;
        }
        .main-table th, .main-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 12px;
        }
        .main-table thead th {
            background-color: #4F46E5; /* Warna Indigo */
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .main-table tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .logo {
            width: 50px;
            height: 50px;
        }
        h1 {
            font-size: 24px;
            margin: 0;
        }
        .sub-header {
            font-size: 14px;
            margin-top: 5px;
            color: #555;
        }
        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
        .page-number:before {
            content: "Halaman " counter(page);
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 60px;">
                {{-- Logo Aplikasi --}}
                <svg class="logo" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#4F46E5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </td>
            <td>
                <h1>DigiPustaka</h1>
                <p class="sub-header">Laporan Peminjaman Buku</p>
            </td>
            <td class="text-right">
                <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($tanggalAwal)->isoFormat('D MMMM Y') }}<br>
                s/d {{ \Carbon\Carbon::parse($tanggalAkhir)->isoFormat('D MMMM Y') }}</p>
            </td>
        </tr>
    </table>
    
    <hr style="margin-top: 20px; margin-bottom: 20px;">

    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->buku->judul_buku }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d-m-Y') : '-' }}</td>
                    <td class="text-center">{{ $item->status == 'pinjam' ? 'Dipinjam' : 'Kembali' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data peminjaman untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('D MMMM Y, HH:mm') }} - DigiPustaka
    </div>

</body>
</html>