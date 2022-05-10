<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Validator;

class BookController extends Controller
{
    protected $books;

    public function __construct()
    {
       $this->books = new Book();
    }

    public function index(Request $request)
    {
        if($request->keyword){
            $bookFilteredList = $this->books->getBooksFilteredByTitle($request);

            if($bookFilteredList->isEmpty()){
                return response()->json([
                    'message' => 'Record not found'
                ], 404);
            }

            return response()->json([
                'data' => $bookFilteredList
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


    public function importFile(Request $request){

        $validator = Validator::make($request->all(),[
            'file' => 'required|file|mimes:csv,xml,xlsx'
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        }

        $this->books->importBookCsvFile($request);

        return response()-> json([
            'message' => 'File imported successfully'
        ], 200);
    }


}
