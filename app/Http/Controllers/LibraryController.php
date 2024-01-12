<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibraryRequest;
use App\Http\Requests\UpdateLibraryRequest;
use Illuminate\Http\Request;
use App\Models\Library;
use App\Models\Book;
use Illuminate\Support\Facades\File;


class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $orderByColumn = $request->input('sort_by', 'name');
        $orderByDirection = $request->input('sort_order', 'asc');

        if ($orderByColumn != 'name') {
            $orderByColumn = 'name';
        }

        $qb = Book::orderBy($orderByColumn, $orderByDirection);

        if ($request->has('search')) {
            $qb->where('name', 'LIKE', '%' . strval($request->input('search')) . '%');
        }

        if ($request->ajax()) {
            return $qb->get();
        }
        return view('library.index', ['libraries' => $qb->get()]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('library.create', ['books' => Book::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLibraryRequest $request)
    {
        $library = new Library();
        $library->name = $request->input('name');

        if ($request->input('image')) {
            $fileName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $fileName);
            $library->image = $fileName;
        }

        $library->save();

        $library->books()->attach($request->input('attachments'));

        return redirect('/library');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Library::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $library = Library::findOrFail($id);
        $attachments = array_map(function ($item) {
            return $item['id'];
        }, $library->books->all());

        return view('library.edit', ['library' => $library, 'attachments' => $attachments, 'books' => Book::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateLibraryRequest $request)
    {
        $library = Library::findOrFail($id);
        $library->name = $request->input('name');

        if ($request->input('image')) {
            if ($library->image && File::exists(public_path('uploads/') . $library->image)) {
                File::delete(public_path('uploads/') . $library->image);
            }

            $fileName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $fileName);
            $library->image = $fileName;
        }

        $library->save();

        $library->books()->sync($request->input('attachments'));

        return redirect('/library');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $library = Library::findOrFail($id);
        $library->books()->detach();

        $library->delete();

        return redirect('/library');
    }
}
