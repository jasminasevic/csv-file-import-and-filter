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

    public function getBooksFilteredByTitle($request){
        return $this::where('title', 'LIKE', '%' . $request->title . '%')
            ->paginate($this->resultsPerPage);
    }

    public function getBooksFilteredByYear($request){

        $condition = $request->year;

        switch ($condition) {
            case "less_than_5":
                return $this::where((DB::raw('STR_TO_DATE(issue_date, "%d/%m/%Y")')), '>', Carbon::now()->subYears(5))
                   ->paginate($this->resultsPerPage);

            case "less_than_10":
                return $this::where((DB::raw('STR_TO_DATE(issue_date, "%d/%m/%Y")')), '>', Carbon::now()->subYears(10))
                    ->paginate($this->resultsPerPage);

            case "more_than_10":
                return $this::where((DB::raw('STR_TO_DATE(issue_date, "%d/%m/%Y")')), '<', Carbon::now()->subYears(10))
                    ->paginate($this->resultsPerPage);

            default:
                return $this::paginate($this->resultsPerPage);
        }
    }

    public function importBookCsvFile($request){
        Excel::import(new BookImport, $request->file);
    }
}
