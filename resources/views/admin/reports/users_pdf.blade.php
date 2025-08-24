<h2>Laporan Data User</h2>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Nomor HP</th>
            <th>Email</th>
            <th>Phone Verified</th>
            <th>Member Status</th>
            <th>Status Akun</th>
            <th>Expired Date</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Age</th>
            <th>ID Type</th>
            <th>ID Number</th>
            <th>Alamat</th>
            <th>Kabupaten/Kota</th>
            <th>Provinsi</th>
            <th>Pekerjaan</th>
            <th>Pendidikan</th>
            <th>Kelas/Jurusan</th>
            <th>Email Verified</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $u)
        <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->role }}</td>
            <td>{{ $u->phone_number }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->is_phone_verified ? 'Ya' : 'Tidak' }}</td>
            <td>{{ $u->member_status }}</td>
            <td>{{ $u->status_account }}</td>
            <td>{{ $u->expired_date }}</td>
            <td>{{ $u->gender }}</td>
            <td>{{ $u->birth_date }}</td>
            <td>{{ $u->age }}</td>
            <td>{{ $u->id_type }}</td>
            <td>{{ $u->id_number }}</td>
            <td>{{ $u->address }}</td>
            <td>{{ $u->regency }}</td>
            <td>{{ $u->province }}</td>
            <td>{{ $u->jobs }}</td>
            <td>{{ $u->education }}</td>
            <td>{{ $u->class_department }}</td>
            <td>{{ $u->email_verified_at }}</td>
            <td>{{ $u->created_at }}</td>
            <td>{{ $u->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
