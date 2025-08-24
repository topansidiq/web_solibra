<h2 style="text-align:center;">Laporan Data Buku</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tgl. Pengadaan</th>
                <th>No. Identifikasi</th>
                <th>Bahan</th>
                <th>Bentuk Fisik</th>
                <th>Edisi</th>
                <th>Tempat Terbit</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Deskripsi Fisik</th>
                <th>Sumber Perolehan</th>
                <th>Nama Perolehan</th>
                <th>ISBN</th>
                <th>Harga</th>
                <th>Bahasa</th>
                <th>Stok</th>
                <th>Deskripsi</th>
                <th>Cover</th>
                <th>Dibuat</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->supply_date }}</td>
                <td>{{ $book->identification_number }}</td>
                <td>{{ $book->material }}</td>
                <td>{{ $book->physical_shape }}</td>
                <td>{{ $book->edition }}</td>
                <td>{{ $book->publication_place }}</td>
                <td>{{ $book->publisher }}</td>
                <td>{{ $book->year }}</td>
                <td>{{ $book->physical_description }}</td>
                <td>{{ $book->acquisition_source }}</td>
                <td>{{ $book->acquisition_name }}</td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->price }}</td>
                <td>{{ $book->language }}</td>
                <td>{{ $book->stock }}</td>
                <td>{{ $book->description }}</td>
                <td>{{ $book->cover }}</td>
                <td>{{ $book->created_at }}</td>
                <td>{{ $book->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
