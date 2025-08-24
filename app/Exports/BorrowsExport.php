<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class BorrowsExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function collection()
    {
        return new Collection(
            $this->data->map(function ($borrow) {
                return [
                    'ID'            => $borrow->id,
                    'Nama User'     => $borrow->user->name ?? '-',
                    'Email User'    => $borrow->user->email ?? '-',
                    'Judul Buku'    => $borrow->book->title ?? '-',
                    'Penulis'       => $borrow->book->author ?? '-',
                    'Tanggal Pinjam'=> $borrow->borrowed_at,
                    'Tanggal Kembali'=> $borrow->return_date,
                    'Jatuh Tempo'   => $borrow->due_date,
                    'Status'        => $borrow->status,
                    'Jumlah Perpanjangan' => $borrow->extend,
                    'Created At'    => $borrow->created_at,
                    'Updated At'    => $borrow->updated_at,
                ];
            })
        );
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama User',
            'Email User',
            'Judul Buku',
            'Penulis',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Jatuh Tempo',
            'Status',
            'Jumlah Perpanjangan',
            'Created At',
            'Updated At',
        ];
    }
}
