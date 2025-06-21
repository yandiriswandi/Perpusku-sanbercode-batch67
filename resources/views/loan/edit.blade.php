@extends('layouts.layout')

@section('title')
    Edit Loan
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('loan.update', $loan->id) }}">
                @csrf
                @method('PUT')

                {{-- Code (readonly) --}}
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Code</label>
                        <input type="text" name="code" class="form-control" value="{{ $loan->code }}" disabled>
                    </div>

                    {{-- Borrower --}}
                    <div class="form-group col-md-6">
                        <label>Borrower</label>
                        <select class="js-example-basic-single form-control" name="user_id">
                            @foreach ($user->where('role', 'user') as $item)
                                <option value="{{ $item->id }}" {{ $loan->user_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->code }} - {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Borrowed / Due / Returned --}}
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Borrowed At</label>
                        <input type="date" name="borrowed_at" class="form-control"
                            value="{{ $loan->borrowed_at->format('Y-m-d') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Due At</label>
                        <input type="date" name="due_at" class="form-control" value="{{ $loan->due_at->format('Y-m-d') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Returned At</label>
                        <input type="date" name="returned_at" class="form-control"
                            value="{{ optional($loan->returned_at)->format('Y-m-d') }}">
                    </div>
                </div>

                {{-- Fine and Note --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Fine</label>
                        <input type="number" name="fine" class="form-control" step="0.01" value="{{ $loan->fine }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Note</label>
                        <textarea name="note" class="form-control">{{ $loan->note }}</textarea>
                    </div>
                </div>

                <hr>
                <h5>Books</h5>
                <div id="book-container">
                    @foreach ($loan->bookLoans as $index => $bookLoan)
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <select name="books[{{ $index }}][book_id]" class="form-control">
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}" {{ $bookLoan->book_id == $book->id ? 'selected' : '' }}>
                                            {{ $book->code }} - {{ $book->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" name="books[{{ $index }}][total]" class="form-control" min="1"
                                    value="{{ $bookLoan->total }}">
                            </div>
                            <div class="col-sm-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger"
                                    onclick="this.parentElement.parentElement.remove()">−</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-success" onclick="addBookRow()">+ Add Book</button>

                <script>
                    let bookIndex = {{ count($loan->bookLoans) }};
                    function addBookRow() {
                        const container = document.getElementById('book-container');
                        const html = `
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <select name="books[\${bookIndex}][book_id]" class="form-control">
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id }}">{{ $book->code }} - {{ $book->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="number" name="books[\${bookIndex}][total]" class="form-control" min="1" value="1">
                                        </div>
                                        <div class="col-sm-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger"
                                                onclick="this.parentElement.parentElement.remove()">−</button>
                                        </div>
                                    </div>
                                `;
                        container.insertAdjacentHTML('beforeend', html);
                        bookIndex++;
                    }
                </script>

                <hr>
                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('loan.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
@endsection