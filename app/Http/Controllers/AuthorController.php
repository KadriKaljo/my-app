<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('authors/Index', [
            'authors'=> Author:: paginate(30),
        ]);
    }


    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('authors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'date_of_birth' => 'required|date',
        ]);

        Author::create($data);

        return redirect()-> route('authors.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'date_of_birth' => 'required|date',
        ]);

        $author->update($data);

        return redirect()->route('authors.index', request()->only('page'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return Inertia::render('authors/Show', [
            'author'=> $author,
        ]);

        return redirect()-> route('authors.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return Inertia::render('authors/Edit', [
            'author' => $author,
        ]);

        return redirect()->route('authors.index', request()->only('page'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return back();
    }
}
