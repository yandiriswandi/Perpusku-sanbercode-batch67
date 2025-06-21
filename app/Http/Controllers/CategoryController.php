<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsAdmin;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\Middleware;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function middleware()
    // {
    //     return [new Middleware(IsAdmin::class, except: ['index', 'show'])];
    // }

    public function index()
    {
        $category = Category::all();
        return view('category.index', ['category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:categories,code',
            'description' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->code = $request->code;
        $category->description = $request->description;
        $category->save();
        return redirect('/category')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        return view('category.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        return view('category.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:categories,code,' . $id,
            'description' => 'required',
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->code = $request->code;
        $category->description = $request->description;
        $category->save();
        return redirect(to: '/category')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        //contoh menggunakan route name
        return redirect()->route('category.index')->with('success', 'Data berhasil dihapus!');
    }
}
