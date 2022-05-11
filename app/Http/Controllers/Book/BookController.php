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
        if($request->title){
            $booksFilteredByTitle = $this->books->getBooksFilteredByTitle($request);

            if($booksFilteredByTitle->isEmpty()){
                return response()->json([
                    'message' => 'Record not found'
                ], 404);
            }

            return response()->json([
                'data' => $booksFilteredByTitle
            ], 200);
        }

        if($request->year){
            $booksFilteredByYear = $this->books->getBooksFilteredByYear($request);

            if(!$booksFilteredByYear){
                return response()->json([
                    'message' => 'Record not found'
                ], 404);
            }

            return response()->json([
                'data' => $booksFilteredByYear
            ], 200);
        }

        $bookList = $this->books->getBooks();
        return response()->json([
            'data' => $bookList
        ], 200);
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
