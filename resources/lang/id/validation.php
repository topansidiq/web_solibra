<?php

return [

    'required' => 'Kolom :attribute wajib diisi.',
    'email' => 'Kolom :attribute harus berisi alamat email yang valid.',
    'min' => [
        'string' => 'Kolom :attribute minimal harus :min karakter.',
    ],
    'max' => [
        'string' => 'Kolom :attribute maksimal :max karakter.',
    ],
    'unique' => 'Kolom :attribute sudah digunakan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',

    'attributes' => [
        'name' => 'nama',
        'email' => 'alamat email',
        'password' => 'kata sandi',
        'phone_number' => 'nomor telepon',
        'birth_date' => 'tanggal lahir',
        // tambahkan sesuai kebutuhan
    ],
];
