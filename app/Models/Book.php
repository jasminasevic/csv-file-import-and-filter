<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Imports\BookImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function getBook($id){
        return $this::find($id);
    }

    public function getBooks(){
        return $this::paginate($this->resultsPerPage);
    }

    public function getFilteredBooks($request){

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

        return $queryBuilder->paginate($this->resultsPerPage);
    }

    public function importBookCsvFile($request){
        Excel::import(new BookImport, $request->file);
    }
}
