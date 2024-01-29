<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\LibraryBook;
use App\Http\Requests\StoreLibraryBookRequest;
use App\Http\Requests\UpdateLibraryBookRequest;
use Illuminate\Database\Eloquent\Model;

class LibraryBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books=LibraryBook::all();
        return view('backend.library-book.index',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('backend.library-book.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLibraryBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLibraryBookRequest $request)
    {
        request()->validate([
            'title'=>'required',
            'category'=>'required',
            'author'=>'required',
            'noOfBook'=>'required',
            'price'=>'required',
        ]);
        $book=new LibraryBook();
        $book->title=$request->title;
        $book->category=$request->category;
        $book->author=$request->author;
        $book->no_of_book=$request->noOfBook;
        $book->price=$request->price;
        $dir="public/library-book/cover";
        $newName = uniqid()."_cover.".$request->file("cover")->getClientOriginalExtension();
        $request->file("cover")->storeAs($dir,$newName);
        $book->cover = $newName;
        $book->save();
        return redirect()->route('library-book.index')->with('success','Book created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LibraryBook  $libraryBook
     * @return \Illuminate\Http\Response
     */
    public function show(LibraryBook $libraryBook)
    {
        return view('backend.library-book.show',compact('libraryBook'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LibraryBook  $libraryBook
     * @return \Illuminate\Http\Response
     */
    public function edit(LibraryBook $libraryBook)
    {
        $categories=Category::all();
        return view('backend.library-book.edit',compact('libraryBook','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLibraryBookRequest  $request
     * @param  \App\Models\LibraryBook  $libraryBook
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLibraryBookRequest $request, LibraryBook $libraryBook)
    {
        request()->validate([
            'title'=>'required',
            'category'=>'required',
            'author'=>'required',
            'noOfBook'=>'required',
            'price'=>'required',
        ]);
        $libraryBook->title=$request->title;
        $libraryBook->category=$request->category;
        $libraryBook->author=$request->author;
        $libraryBook->no_of_book=$request->noOfBook;
        $libraryBook->price=$request->price;
        if ($request->file("cover")){
            $dir="public/library-book/cover";
            $newName = uniqid()."_cover.".$request->file("cover")->getClientOriginalExtension();
            $request->file("cover")->storeAs($dir,$newName);
            $libraryBook->cover= $newName;
        }
        $libraryBook->update();
        return redirect()->route('library-book.index')->with('success','Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LibraryBook  $libraryBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibraryBook $libraryBook)
    {
        $libraryBook->delete();
        return back()->with('success','Book deleted successfully.');
    }
}
