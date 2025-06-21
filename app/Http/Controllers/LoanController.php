<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::all();
        return view('loan.index', ['loans' => $loans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $book = Book::all();
        return view('loan.create', ['user' => $user, 'books' => $book]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'code' => 'required|unique:loans,code',
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date|after_or_equal:borrowed_at',
            'returned_at' => 'nullable|date|after_or_equal:borrowed_at',
            'user_id' => 'required|exists:users,id',
            'fine' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        $loanCount = Loan::count() + 1;
        $timestamp = Carbon::now()->format('YmdHis');

        $code = 'LN-' . $loanCount . '-' . $timestamp;

        $loan = new Loan();
        $loan->code = $code;
        $loan->borrowed_at = $request->borrowed_at;
        $loan->due_at = $request->due_at;
        $loan->returned_at = $request->returned_at;
        $loan->user_id = $request->user_id;
        $loan->fine = $request->fine;
        $loan->note = $request->note;
        $loan->created_by = Auth::id();
        $loan->save();

        foreach ($request->books as $bookData) {
            BookLoan::create([
                'loan_id' => $loan->id,
                'book_id' => $bookData['book_id'],
                'total' => $bookData['total'],
                'user_id' => $request->user_id
            ]);
            $book = Book::find($bookData['book_id']);
            if ($book) {
                $book->decrement('stock', $bookData['total']);
            }
        }
        return redirect('/loan')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loan = Loan::find($id);
        $user = User::all();
        $books = Book::all();
        return view('loan.show', compact('loan', 'user', 'books'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $loan = Loan::with('bookLoans')->findOrFail($id);
        $user = User::all();
        $books = Book::all();
        return view('loan.edit', compact('loan', 'user', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        // dd($request->returned_at, !empty($request->returned_at));

        $request->validate([
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date|after_or_equal:borrowed_at',
            'returned_at' => 'nullable|date|after_or_equal:borrowed_at',
            'user_id' => 'required|exists:users,id',
            'fine' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.total' => 'required|integer|min:1',
        ]);

        // ✅ 1. Kembalikan stok lama
        foreach ($loan->bookLoans as $oldLoan) {
            $book = Book::find($oldLoan->book_id);
            if ($book) {
                $book->increment('stock', $oldLoan->total);
            }
        }

        // ✅ 2. Hapus semua book_loans lama
        $loan->bookLoans()->delete();

        // ✅ 3. Update data loan utama
        $loan->update([
            'borrowed_at' => $request->borrowed_at,
            'due_at' => $request->due_at,
            'returned_at' => $request->returned_at,
            'user_id' => $request->user_id,
            'fine' => $request->fine ?? 0,
            'note' => $request->note,
            'status' => $request->filled('returned_at') ? 1 : $loan->status,
            'updated_by' => auth()->id(),
        ]);

        // ✅ 4. Tambahkan ulang data buku baru & kurangi stok
        foreach ($request->books as $bookData) {
            BookLoan::create([
                'loan_id' => $loan->id,
                'book_id' => $bookData['book_id'],
                'total' => $bookData['total'],
                'user_id' => $request->user_id
            ]);

            $book = Book::find($bookData['book_id']);
            if ($book) {
                $book->decrement('stock', $bookData['total']);
            }
        }

        return redirect('/loan')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loan = Loan::findOrFail($id);

        // Hanya izinkan hapus jika status 2 (Approved) atau 3 (Overdue) — ganti sesuai enum kamu
        if (!in_array($loan->status, [2, 3])) {
            return redirect()->route('loan.index')->with('error', 'Loan hanya bisa dihapus jika status Approved atau Overdue.');
        }

        // Hapus semua book_loans yang terkait dengan loan ini
        $loan->bookLoans()->delete();

        // Hapus loan-nya
        $loan->delete();

        return redirect()->route('loan.index')->with('success', 'Data berhasil dihapus!');

    }
    public function updateStatus(Request $request, Loan $loan)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:5',
        ]);

        $newStatus = $request->status;

        // Jika status baru adalah 2 (Approved) atau 3 (Overdue), anggap buku dikembalikan
        if (in_array($newStatus, [2, 3])) {
            $bookLoans = BookLoan::where('loan_id', $loan->id)->get();

            foreach ($bookLoans as $bookLoan) {
                $book = Book::find($bookLoan->book_id);
                if ($book) {
                    $book->increment('stock', $bookLoan->total);
                }
            }
        }

        // Jika bukan 2/3, hanya update status biasa
        $loan->status = $newStatus;
        $loan->save();

        return redirect()->back()->with('success', 'Loan status updated.');
    }

}
