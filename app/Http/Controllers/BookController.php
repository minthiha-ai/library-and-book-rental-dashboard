<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Category;
use App\Imports\BookImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    protected $path = 'storage/images/cover/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books=Book::with(['category', 'genres'])->when(isset(request()->search),function ($q){
            $search=request()->search;
            return $q->where("title", "like", "%$search%")->orWhere("code", "like", "%$search%");
        })
        ->latest()
        ->paginate(10);
        $books->appends(['search' => request()->search]);

        return view('backend.book.index',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        $genres = Genre::all();
        return view('backend.book.create',compact('categories','genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        // return $request->all();
        request()->validate([
            'title'=>'required',
            'category'=>'required',
            'genre' => 'required',
            'author'=>'required',
            'noOfBook'=>'required',
            'book_id' => 'required'
        ]);
        $book=new Book();
        $book->title=$request->title;
        $book->category_id=$request->category;
        $book->author=$request->author;
        $book->credit_point=$request->credit_point;
        $book->no_of_book=$request->noOfBook;
        $book->remain=$request->noOfBook;
        $book->description=$request->description;
        $book->code=$request->book_id;


        if ($request->cover) {
            $photoName = uniqid('cover').'.'.$request->cover[0]->extension();
            $book->cover = $photoName;
        }else{
            $book->cover = '';
        }

        if ($book->save()) {
            $genres = $request->genre;
            $book->genres()->attach($genres);
            if($request->cover){
                $request->cover[0]->move(public_path($this->path), $photoName);
            }
            return to_route('book.index')->with('success', 'Book created successfully!');
        }else{
            return back()->with('warning', 'Something wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('backend.book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $categories=Category::all();
        $genres = Genre::all();
        return view('backend.book.edit',compact('book','categories', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        // return $request->genre;

        request()->validate([
            'title'=>'required',
            'category'=>'required',
            'genre'=>'required',
            'author'=>'required',
            'noOfBook'=>'required',
            'book_id' => 'required'
        ]);
        $book->title=$request->title;
        $book->category_id=$request->category;
        $book->author=$request->author;
        $book->credit_point=$request->credit_point;
        $book->no_of_book=$request->noOfBook;
        $book->remain=$request->remain;
        $book->description=$request->description;
        $book->code=$request->book_id;

        if ($request->cover) {
            if($book->cover != ''){
                if (file_exists($this->path.$book->cover)) {
                    unlink(public_path($this->path).$book->cover);
                }
            }
            $photoName = uniqid('cover').'.'.$request->cover[0]->extension();
            $book->cover = $photoName;
        }
        $genres = $request->genre;


        if (!empty($genres)) {
            $genres = Genre::whereIn('id', $genres)->get();
            if ($genres->isEmpty()) {
                $book->genres()->attach($request->genres);
            }
            $book->genres()->sync($genres);
        }

        if ($book->save()) {

            if($request->cover){
                $request->cover[0]->move(public_path($this->path), $photoName);
            }
            return to_route('book.index')->with('success', 'Book updated successfully!');
        }else{
            return back()->with('warning', 'Something wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if($book->cover != ''){
            if(file_exists($this->path.$book->cover)){
                unlink(public_path($this->path).$book->cover);
            }
        }
        $book->delete();
        return back()->with('success','Book deleted successfully.');
    }

    public function bookStatus()
    {
        $book = Book::find(\request()->id);
        $book->status=\request()->status;
        $book->update();
        return redirect()->route('book.index')->with("toast","New Arrival book added.");
    }

    public function importBooks(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new BookImport, $file);

        return redirect()->back()->with('success', 'Books imported successfully.');
    }
}
