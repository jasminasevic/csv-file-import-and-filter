<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Imports\BookImport;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class BookController extends Controller
{

    public function index(Request $request)
    {
        if($request->keyword){
            $bookFilteredList = Book::where('title', 'LIKE', '%' . $request->keyword . '%')
                ->paginate(10);

            if($bookFilteredList->isEmpty()){
                return response()->json([
                    'message' => 'Record not found'
                ], 404);
            }

            return response()->json([
                'data' => $bookFilteredList
            ], 200);
        }

        $bookList = Book::paginate(10);
        return response()->json([
            'data' => $bookList
        ], 200);
    }


    public function show($id)
    {
        $book = Book::find($id);

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

        Excel::import(new BookImport, $request->file);

        return response()-> json([
            'message' => 'File imported successfully'
        ], 200);
    }


}
