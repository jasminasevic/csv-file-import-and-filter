<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Imports\BookImport;
use Maatwebsite\Excel\Facades\Excel;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'issue_date'
    ];

    public function getBook($id){
        return $this::find($id);
    }

    public function getBooks(){
        return $this::paginate(10);
    }

    public function getBooksFilteredByTitle($request){
        return $this::where('title', 'LIKE', '%' . $request->keyword . '%')
            ->paginate(10);
    }

    public function importBookCsvFile($request){
        Excel::import(new BookImport, $request->file);
    }
}
