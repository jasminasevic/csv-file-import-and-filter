<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = [
            [
                'title' => 'Nineteen Eighty-Four',
                'author' => 'George Orwell',
                'publisher' => 'Secker & Warburg',
                'issue_date' => '08/09/1949'
            ],
            [
                'title' => 'Anna Karenina',
                'author' => 'Leo Tolstoy',
                'publisher' => 'Simon & Schuster',
                'issue_date' => '26/01/2016'
            ],
            [
                'title' => 'PHP In Action: Objects, Design, Agility',
                'author' => 'Daginn Reiersol, Chris Shiflett, and Marcus Baker',
                'publisher' => 'Manning Publications',
                'issue_date' => '04/05/2007'
            ]
        ];

        foreach ($books as $key=>$value) {
            Book::create($value);
        }
    }
}
