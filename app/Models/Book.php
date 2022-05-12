<?php

namespace App\Models;

use App\Exceptions\GeneralJsonException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Imports\BookImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    public $resultsPerPage = 10;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'issue_date'
    ];

    public function getBook($id)
    {
        $book = $this::find($id);
        throw_if(is_null($book), GeneralJsonException::class, 'Record not found');

        return $book;
    }

    public function getBooks()
    {
        $books = $this::paginate($this->resultsPerPage);
        throw_if(isEmpty($books), GeneralJsonException::class, 'No results');

        return $books;
    }

    public function getFilteredBooks($request)
    {
        $parametersMap = array(
            'less_than_five' => array('>', 5),
            'less_than_ten' => array('>', 10),
            'greater_than_ten' => array('<', 10),
        );

        $queryBuilder = $this::query();

        if($request->year){
            $queryBuilder->where((DB::raw('STR_TO_DATE(issue_date, "%d/%m/%Y")')), $parametersMap[$request->year][0],
                Carbon::now()->subYears( $parametersMap[$request->year][1]));
        }

        if($request->title){
            $queryBuilder->where('title', 'LIKE', '%' . $request->title . '%');
        }

        $books = $queryBuilder->paginate($this->resultsPerPage);
        throw_if($books->isEmpty(), GeneralJsonException::class, 'No results.');

        return $books;
    }

    public function importBookCsvFile($request){
        Excel::import(new BookImport, $request->file);
    }
}
