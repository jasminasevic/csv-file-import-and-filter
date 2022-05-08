<?php

namespace App\Imports;

use App\Models\BookModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BookImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BookModel([
            'title' => $row['title'],
            'author' => $row['author'],
            'publisher' => $row['publisher'],
            'issue_date' => $row['issue_date']
        ]);
    }
}
