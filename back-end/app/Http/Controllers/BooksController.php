<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBook()
    {
        return Book:: latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createBook(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'author'=>'required',
            'length'=>'required',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->length = $request->length;

        $book->save();
       
        return response()->json(['message' => "created successfully!" , "book" => $book],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->length = $request->length;

        $book->save();

        return response()->json(['message' => "updated successfully!" , "book" => $book],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = Book::destroy($id);

        if($isDeleted == 1) {
            return response()->json(['message' => 'Deleted successfully'], 200);
        }else{
            return response()->json(['message' => 'ID NOT FOUND'], 404);
        }
    }


    // ==================Search book==================
    public function search($title)
    {   
        return Book::where('title','like','%'.$title. '%')->get();
    }
}
