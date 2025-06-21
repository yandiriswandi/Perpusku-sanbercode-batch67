@extends('layouts.layout')

@section('title')
    Add Loan
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" method="POST" action="{{ route('loan.store') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Code</label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                            value="{{ old('code') }}" placeholder="AUTO" disabled>
                        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="user_id">Name</label>
                        <select class="js-example-basic-single w-100 form-control  @error('user_id') is-invalid @enderror"
                            name="user_id">
                            <option>Choose Book borrower Name</option>
                            @forelse ($user->where('role', 'user') as $item)
                                <option value={{$item->id}}>{{$item->code}}-{{$item->name}}</option>
                            @empty
                                <option>Data tidak ditemukan</option>
                            @endforelse
                        </select>

                        @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Borrowed At</label>
                        <input type="date" name="borrowed_at"
                            class="form-control @error('borrowed_at') is-invalid @enderror"
                            value="{{ old('borrowed_at') }}">
                        @error('borrowed_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Due At</label>
                        <input type="date" name="due_at" class="form-control @error('due_at') is-invalid @enderror"
                            value="{{ old('due_at') }}">
                        @error('due_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>    

                    <div class="form-group col-md-6">
                        <label>Fine</label>
                        <input type="number" name="fine" step="0.01"
                            class="form-control @error('fine') is-invalid @enderror" value="{{ old('fine', 0) }}">
                        @error('fine') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Note</label>
                        <textarea name="note"
                            class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
                        @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <hr>
                <h5 class="mb-4">Books</h5>
                <div id="book-container">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <select name="books[0][book_id]" class="form-control">
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->code }}-{{ $book->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="number" name="books[0][total]" class="form-control" min="1" value="1">
                        </div>
                        <div class="col-sm-2 d-flex align-items-end">
                            <button type="button" class="btn btn-success" onclick="addBookRow()">+</button>
                        </div>
                    </div>
                </div>

                <script>
                    let bookIndex = 1;

                    function addBookRow() {
                        const container = document.getElementById('book-container');
                        const html = `
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <select name="books[${bookIndex}][book_id]" class="form-control">
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->code }}-{{ $book->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" name="books[${bookIndex}][total]" class="form-control" min="1" value="1">
                            </div>
                            <div class="col-sm-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger" onclick="this.parentElement.parentElement.remove()">−</button>
                            </div>
                        </div>`;
                        container.insertAdjacentHTML('beforeend', html);
                        bookIndex++;
                    }
                </script>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-light" onclick="history.back()" type="button">Cancel</button>
            </form>
        </div>
    </div>
@endsection