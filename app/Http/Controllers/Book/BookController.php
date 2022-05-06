<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\BookModel;

class BookController extends Controller
{
    public function getAllBooks(){
        return response()->json(BookModel::get(), 200);
    }

    public function getBook($id){
        return response()->json(BookModel::find($id), 200);
    }
}
