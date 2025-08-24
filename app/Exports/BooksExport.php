<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class BooksExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function collection()
    {
        return new Collection($this->data);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul',
            'Penulis',
            'Tanggal Pengadaan',
            'Nomor Identifikasi',
            'Bahan',
            'Bentuk Fisik',
            'Edisi',
            'Tempat Terbit',
            'Penerbit',
            'Tahun Terbit',
            'Deskripsi Fisik',
            'Sumber Perolehan',
            'Nama Perolehan',
            'ISBN',
            'Harga',
            'Bahasa',
            'Stok',
            'Deskripsi',
            'Cover',
            'Dibuat Pada',
            'Diupdate Pada',
        ];
    }

    public function map($book): array
    {
        return [
            $book->id,
            $book->title,
            $book->author,
            $book->supply_date,
            $book->identification_number,
            $book->material,
            $book->physical_shape,
            $book->edition,
            $book->publication_place,
            $book->publisher,
            $book->year,
            $book->physical_description,
            $book->acquisition_source,
            $book->acquisition_name,
            $book->isbn,
            $book->price,
            $book->language,
            $book->stock,
            $book->description,
            $book->cover,
            $book->created_at,
            $book->updated_at,
        ];
    }
}
