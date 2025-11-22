<?php

namespace App\Exports;

use App\Models\Author;
use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AuthorsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Author::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Books Count',
            'Created At',
            'Updated At'
        ];
    }
}

