<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shelf = Shelf::all();
        return view('shelf.index', ['shelf' => $shelf]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shelf.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:categories,code',
        ]);

        $shelf = new Shelf();
        $shelf->name = $request->name;
        $shelf->code = $request->code;
        $shelf->description = $request->description;
        $shelf->save();
        return redirect('/shelf')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shelf = Shelf::find($id);
        return view('shelf.show', ['shelf' => $shelf]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shelf = Shelf::find($id);
        return view('shelf.edit', ['shelf' => $shelf]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:categories,code,' . $id,
        ]);

        $shelf = Shelf::find($id);
        $shelf->name = $request->name;
        $shelf->code = $request->code;
        $shelf->description = $request->description;
        $shelf->save();
        return redirect(to: '/shelf')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shelf = Shelf::find($id);
        $shelf->delete();
        //contoh menggunakan route name
        return redirect()->route('shelf.index')->with('success', 'Data berhasil dihapus!');
    }
}
