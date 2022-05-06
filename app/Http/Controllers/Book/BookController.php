<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookModel;

class BookController extends Controller
{
    public function book(){
        return response()->json(BookModel::get(), 200);
    }
}
