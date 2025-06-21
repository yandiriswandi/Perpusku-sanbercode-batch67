<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with(['category', 'shelf']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('year_published', 'like', "%{$search}%")
                    ->orWhere('stock', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    // Relasi category
                    ->orWhereHas('category', function ($cat) use ($search) {
                        $cat->where('name', 'like', "%{$search}%");
                    })
                    // Relasi shelf
                    ->orWhereHas('shelf', function ($shelf) use ($search) {
                        $shelf->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
            });
        }

        $book = $query->paginate(10)->withQueryString(); // agar pagination tetap bawa query

        return view('book.index', ['book' => $book]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        $shelf = Shelf::all();
        return view('book.create', ['category' => $category, 'shelf' => $shelf]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required|unique:books,code',
            'year_published' => 'digits:4|integer|min:1000|max:' . date('Y'),
            'category_id' => 'required|exists:categories,id',
            'shelf_id' => 'required|exists:shelfs,id',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        if ($request->hasFile('cover_image')) {
            $newImageName = time() . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('asset/image/book_cover'), $newImageName);
        } else {
            $newImageName = null; // atau bisa pakai default image jika perlu
        }

        $book = new Book();
        $book->title = $request->title;
        $book->code = $request->code;
        $book->isbn = $request->isbn;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->year_published = $request->year_published;
        $book->stock = $request->stock;
        $book->category_id = $request->category_id;
        $book->shelf_id = $request->shelf_id;
        $book->description = $request->description;
        $book->cover_image = $newImageName;
        $book->save();
        return redirect('/book')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);
        $category = Category::all();
        $shelf = Shelf::all();
        return view('book.show', ['book' => $book, 'category' => $category, 'shelf' => $shelf]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::find($id);
        $category = Category::all();
        $shelf = Shelf::all();
        return view('book.edit', ['book' => $book, 'category' => $category, 'shelf' => $shelf]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required|unique:books,code,' . $id,
            'year_published' => 'digits:4|integer|min:1000|max:' . date('Y'),
            'category_id' => 'required|exists:categories,id',
            'shelf_id' => 'required|exists:shelfs,id',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        $book = Book::find($id);

        if ($request->hasFile('cover_image')) {
            $oldImagePath = public_path('asset/image/book_cover/' . $book->cover_image);
            //pengecekan apakah file ada karena cover_image bisa null atau bukan required
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $newImageName = time() . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('asset/image/book_cover'), $newImageName);
        } else {
            $newImageName = $book->cover_image;
        }

        $book->title = $request->title;
        $book->code = $request->code;
        $book->isbn = $request->isbn;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->year_published = $request->year_published;
        $book->stock = $request->stock;
        $book->category_id = $request->category_id;
        $book->shelf_id = $request->shelf_id;
        $book->description = $request->description;
        $book->cover_image = $newImageName;
        $book->save();
        return redirect('/book')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);
        $book->delete();
        //contoh menggunakan route name
        return redirect()->route('book.index')->with('success', 'Data berhasil dihapus!');
    }
}
