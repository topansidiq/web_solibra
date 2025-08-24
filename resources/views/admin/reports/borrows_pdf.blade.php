<h2>Laporan Data Peminjaman</h2>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama User</th>
            <th>Email User</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
            <th>Jumlah Perpanjangan</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $b)
        <tr>
            <td>{{ $b->id }}</td>
            <td>{{ $b->user->name ?? '-' }}</td>
            <td>{{ $b->user->email ?? '-' }}</td>
            <td>{{ $b->book->title ?? '-' }}</td>
            <td>{{ $b->book->author ?? '-' }}</td>
            <td>{{ $b->borrowed_at }}</td>
            <td>{{ $b->return_date }}</td>
            <td>{{ $b->due_date }}</td>
            <td>{{ $b->status }}</td>
            <td>{{ $b->extend }}</td>
            <td>{{ $b->created_at }}</td>
            <td>{{ $b->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
