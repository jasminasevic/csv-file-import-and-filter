<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Validator;
use App\Http\Requests\ImportCsvFileRequest;

class BookController extends Controller
{
    protected $books;

    public function __construct()
    {
       $this->books = new Book();
    }

    public function index(Request $request)
    {
        if($request){
            $filteredBooks = $this->books->getFilteredBooks($request);

            if($filteredBooks->isEmpty()){
                return response()->json([
                    'message' => 'Record not found'
                ], 404);
            }

            return response()->json([
                'data' => $filteredBooks
            ], 200);
        }
    }


    public function show($id)
    {
        $book = $this->books->getBook($id);

        if(is_null($book)){
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json([
            'data' => $book
        ], 200);
    }


    public function importFile(ImportCsvFileRequest $request){

        $this->books->importBookCsvFile($request);

        return response()-> json([
            'message' => 'File imported successfully'
        ], 200);
    }

}
