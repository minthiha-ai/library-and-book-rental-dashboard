<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Resources\CategoryResource;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends BaseController
{
    public function index(Request $request){

        $request->validate([
            'page' => 'required|numeric',
            'limit' => 'required|numeric',
        ]);


        $query = Category::with(['books.genres']);

        if (isset($request->latest)) {
            $data = Book::with(['category', 'genres'])->orderby('id','desc')->paginate($request->limit);

            $totalPages = ceil($data->total() / $request->limit);
            return response()->json([
                'success' => true,
                'can_load_more' => $data->total() == 0 || $request->page >= $totalPages ? false : true,
                'data' => BookResource::collection($data)
            ], 200);
        }

        if (isset($request->data)) {
            $data = Book::where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->data . '%')
                      ->orWhere('author', 'LIKE', '%' . $request->data . '%')
                      ->orWhere('code', 'LIKE', '%' . $request->data . '%');
            })->paginate($request->limit);

            $totalPages = ceil($data->total() / $request->limit);
            return response()->json([
                'success' => true,
                'can_load_more' => $data->total() == 0 || $request->page >= $totalPages ? false : true,
                'data' => BookResource::collection($data)
            ], 200);
        }

        $result = $query->orderBy('id', 'desc')->paginate($request->limit);

        $totalPages = ceil($result->total() / $request->limit);

        if ($result->total() == 0) {
            return $this->sendError(204, 'No Product Found');
        }

        return response()->json([
            'success' => true,
            'total' => $result->total(),
            'can_load_more' => $result->total() == 0 || $request->page >= $totalPages ? false : true,
            'data' => CategoryResource::collection($result)
        ], 200);
    }

    public function detail($id)
    {
        $data = Book::where('id', $id)->with(['category', 'genres'])->first();
        if (!$data) {
            return $this->sendError(204, 'No Book Found');
        }
        return $this->sendResponse('success', new BookResource($data));
    }

    public function getBookByGenres(Request $request)
    {
        // return $request->all();

        $request->validate([
            'page' => 'required|numeric',
            'limit' => 'required|numeric',
        ]);

        $selectedGenres = $request->input('genres');

        $data = Book::with('genres')
                    ->whereHas('genres', function ($query) use ($selectedGenres) {
                        $query->whereIn('genres.id', $selectedGenres);
                    })
                    ->paginate($request->limit);

        $totalPages = ceil($data->total() / $request->limit);
        return response()->json([
            'success' => true,
            'can_load_more' => $data->total() == 0 || $request->page >= $totalPages ? false : true,
            'data' => BookResource::collection($data)
        ], 200);
    }

    public function getBookByCategory($id, Request $request)
    {
        // return $id;
        $request->validate([
            'page' => 'required|numeric',
            'limit' => 'required|numeric',
        ]);

        // $selectedCategory = $request->input();

        $data = Book::with('category')
            ->where('category_id', $id)
            ->paginate($request->limit);

        $totalPages = ceil($data->total() / $request->limit);
        return response()->json([
            'success' => true,
            'can_load_more' => $data->total() == 0 || $request->page >= $totalPages ? false : true,
            'data' => BookResource::collection($data)
        ], 200);
    }

}
