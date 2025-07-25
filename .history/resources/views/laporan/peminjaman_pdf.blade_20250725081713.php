<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Peminjaman - DigiPustaka</title>
    <style>
        /* Menggunakan font yang lebih modern dan umum */
        body {
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }

        @page {
            margin: 120px 40px 60px 40px;
        }

        header {
            position: fixed;
            top: -100px;
            left: 0px;
            right: 0px;
            height: 80px;
            border-bottom: 2px solid #0D6EFD;
            /* Warna biru Bootstrap */
        }

        footer {
            position: fixed;
            bottom: -40px;
            left: 0px;
            right: 0px;
            height: 50px;
            font-size: 10px;
            color: #777;
            text-align: center;
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
            width: 60px;
            height: 60px;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }

        .company-details {
            font-size: 11px;
            color: #555;
            line-height: 1.4;
        }

        .report-title {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .report-period {
            font-size: 14px;
            text-align: center;
            margin-bottom: 25px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #dee2e6;
            /* Warna border Bootstrap */
            padding: 10px;
            text-align: left;
        }

        .main-table thead th {
            background-color: #f8f9fa;
            /* Warna header tabel Bootstrap */
            color: #212529;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        .main-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
            /* Warna zebra-striping */
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
    <!-- FOOTER -->
    <footer>
        Laporan ini dibuat secara otomatis oleh sistem DigiPustaka |
        {{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('D MMMM Y, HH:mm') }} | <span class="page-number"></span>
    </footer>

    <!-- HEADER (KOP SURAT) -->
    <header>
        <table class="header-table">
            <tr>
                <td style="width: 70px;">
                    <svg class="logo" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="#0D6EFD">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </td>
                <td>
                    <p class="company-name">DigiPustaka</p>
                    <p class="company-details">Jalan Digital No. 123, Kota Cerdas, Indonesia 12345<br>Email:
                        contact@digipustaka.com | Website: www.digipustaka.com</p>
                </td>
            </tr>
        </table>
    </header>

    <!-- KONTEN UTAMA -->
    <main>
        <p class="report-title">Laporan Transaksi Peminjaman</p>
        <p class="report-period">Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->isoFormat('D MMMM Y') }} s.d.
            {{ \Carbon\Carbon::parse($tanggalAkhir)->isoFormat('D MMMM Y') }}</p>

        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Peminjam</th>
                    <th>Judul Buku</th>
                    <th style="width: 15%;">Tgl Pinjam</th>
                    <th style="width: 15%;">Tgl Kembali</th>
                    <th style="width: 12%;">Status</th>
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
