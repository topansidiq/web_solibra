<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class UsersExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data) { $this->data = $data; }

    public function collection()
    {
        return new Collection(
            $this->data->map(function ($user) {
                return [
                    'ID'              => $user->id,
                    'Nama'            => $user->name,
                    'Role'            => $user->role->name,
                    'Nomor HP'        => $user->phone_number,
                    'Email'           => $user->email,
                    'Phone Verified'  => $user->is_phone_verified ? 'Ya' : 'Tidak',
                    'Member Status'   => $user->member_status,
                    'Status Akun'     => $user->status_account,
                    'Expired Date'    => $user->expired_date,
                    'Gender'          => $user->gender,
                    'Birth Date'      => $user->birth_date,
                    'Age'             => $user->age,
                    'ID Type'         => $user->id_type,
                    'ID Number'       => $user->id_number,
                    'Alamat'          => $user->address,
                    'Kabupaten/Kota'  => $user->regency,
                    'Provinsi'        => $user->province,
                    'Pekerjaan'       => $user->jobs,
                    'Pendidikan'      => $user->education,
                    'Kelas/Jurusan'   => $user->class_department,
                    'Profile Picture' => $user->profile_picture,
                    'Email Verified'  => $user->email_verified_at,
                    'Created At'      => $user->created_at,
                    'Updated At'      => $user->updated_at,
                ];
            })
        );
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Role',
            'Nomor HP',
            'Email',
            'Phone Verified',
            'Member Status',
            'Status Akun',
            'Expired Date',
            'Gender',
            'Birth Date',
            'Age',
            'ID Type',
            'ID Number',
            'Alamat',
            'Kabupaten/Kota',
            'Provinsi',
            'Pekerjaan',
            'Pendidikan',
            'Kelas/Jurusan',
            'Profile Picture',
            'Email Verified',
            'Created At',
            'Updated At',
        ];
    }
}
