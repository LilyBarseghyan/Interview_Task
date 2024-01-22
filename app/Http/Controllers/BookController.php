<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderByColumn = $request->input('sort_by', 'name');
        $orderByDirection = $request->input('sort_order', 'asc');

        if (!in_array($orderByColumn, ['name', 'title'])) {
            $orderByColumn = 'name';
        }

        if (!in_array($orderByDirection, ['asc', 'desc'])) {
            $orderByDirection = 'asc';
        }

        $qb = Book::orderBy($orderByColumn, $orderByDirection);

        if ($request->has('search')) {
            $qb->where('name', 'LIKE', '%' . $request->input('search') . '%')
                ->orWhere('title', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->ajax()) {
            return $qb->get();
        }
        return view('book.index', ['books' => $qb->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = new Book();
        $book->name = $request->input('name');
        $book->title = $request->input('title');
        $book->content = $request->input('content');

        if ($request->has('image')) {
            $fileName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $fileName);
            $book->image = $fileName;
        }

        $book->save();

        return redirect()->route('book.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Book::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view('book.edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateBookRequest $request)
    {
        $book = Book::findOrFail($id);
        $book->name = $request->input('name');
        $book->title = $request->input('title');
        $book->content = $request->input('content');

        if ($request->has('image')) {
            if ($book->image && File::exists(public_path('uploads/') . $book->image)) {
                File::delete(public_path('uploads/') . $book->image);
            }

            $fileName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $fileName);
            $book->image = $fileName;
        }

        $book->save();

        return redirect()->route('book.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if ($book->image && File::exists(public_path('uploads/') . $book->image)) {
            File::delete(public_path('uploads/') . $book->image);
        }
        $book->delete();

        return redirect()->route('book.index');
    }
}
