<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Peminjaman - DigiPustaka</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
        }

        @page {
            margin: 100px 40px 50px 40px;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0px;
            right: 0px;
            height: 60px;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 40px;
            font-size: 9px;
            color: #888;
            text-align: center;
        }

        .page-number:before {
            content: "Halaman " counter(page);
        }

        .report-title {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }

        .report-subtitle {
            font-size: 16px;
            margin-top: 2px;
        }

        .report-period {
            font-size: 11px;
            margin-top: 2px;
            color: #555;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .main-table thead th {
            background-color: #EFEFEF;
            color: #000;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
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
        Laporan ini dicetak secara otomatis oleh Sistem DigiPustaka pada
        {{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('D MMMM Y, HH:mm') }} | <span class="page-number"></span>
    </footer>

    <!-- HEADER (KOP SURAT) -->
    <header>
        <p class="report-title">DigiPustaka</p>
        <p class="report-subtitle">Laporan Transaksi Peminjaman Buku</p>
        <p class="report-period">Untuk Periode yang Berakhir pada
            {{ \Carbon\Carbon::parse($tanggalAkhir)->isoFormat('D MMMM Y') }}</p>
    </header>

    <!-- KONTEN UTAMA -->
    <main>
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Tanggal Pinjam</th>
                    <th style="width: 20%;">Peminjam</th>
                    <th>Judul Buku</th>
                    <th style="width: 15%;">Tanggal Kembali</th>
                    <th style="width: 12%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y') }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->buku?->judul_buku ?? 'Buku Telah Dihapus' }}</td>
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
