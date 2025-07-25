<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Peminjaman - DigiPustaka</title>
    <style>
        @page {
            margin: 100px 25px 50px 25px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0px;
            right: 0px;
            height: 60px;
            line-height: 35px;
            border-bottom: 2px solid #4F46E5;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 40px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }

        .page-number:before {
            content: "Halaman " counter(page);
        }

        .header-table {
            width: 100%;
            border: none;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 50px;
            height: 50px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #4F46E5;
        }

        .company-details {
            font-size: 11px;
            color: #555;
        }

        .report-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }

        .report-period {
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #c2c2c2;
            padding: 10px;
            text-align: left;
        }

        .main-table thead th {
            background-color: #f0f0f0;
            color: #333;
            font-weight: bold;
            text-align: center;
        }

        .main-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #777;
            padding: 20px;
        }
    </style>
</head>

<body>
    <footer>
        DigiPustaka &copy; {{ date('Y') }} - <span class="page-number"></span>
    </footer>

    <header>
        <table class="header-table">
            <tr>
                <td style="width: 60px;">
                    <svg class="logo" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="#4F46E5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </td>
                <td>
                    <p class="company-name">DigiPustaka</p>
                    <p class="company-details">Jalan Digital No. 123, Kota Cerdas, Indonesia<br>Email:
                        contact@digipustaka.com | Telp: (021) 123-4567</p>
                </td>
                <td class="text-right">
                    <strong>Dicetak pada:</strong><br>{{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('D MMMM Y') }}
                </td>
            </tr>
        </table>
    </header>

    <main>
        <p class="report-title">Laporan Transaksi Peminjaman Buku</p>
        <p class="report-period">Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->isoFormat('D MMMM Y') }} s/d
            {{ \Carbon\Carbon::parse($tanggalAkhir)->isoFormat('D MMMM Y') }}</p>

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
                        <td>{{ $item->buku?->judul_buku ?? 'Buku Telah Dihapus' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y') }}</td>
                        <td class="text-center">
                            {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d-m-Y') : '-' }}
                        </td>
                        <td class="text-center">{{ $item->status == 'pinjam' ? 'Dipinjam' : 'Kembali' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="no-data">Tidak ada data transaksi peminjaman untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</body>

</html>
