<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Buku</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, p { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Peminjaman Buku</h2>
    <p>Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->format('d F Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d F Y') }}</p>
    <hr>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->buku->judul_buku }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y') }}</td>
                    <td>{{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $item->status == 'pinjam' ? 'Dipinjam' : 'Kembali' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>