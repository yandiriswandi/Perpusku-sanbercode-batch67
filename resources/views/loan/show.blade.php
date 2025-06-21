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
                        <select class="js-example-basic-single form-control" name="user_id" disabled>
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
                        <input type="date" name="borrowed_at" class="form-control" disabled
                            value="{{ $loan->borrowed_at->format('Y-m-d') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Due At</label>
                        <input type="date" name="due_at" class="form-control" value="{{ $loan->due_at->format('Y-m-d') }}"
                            disabled>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Returned At</label>
                        <input type="date" name="returned_at" class="form-control"
                            value="{{ optional($loan->returned_at)->format('Y-m-d') }}" disabled>
                    </div>
                </div>

                {{-- Fine and Note --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Fine</label>
                        <input type="number" name="fine" class="form-control" step="0.01" value="{{ $loan->fine }}"
                            disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Note</label>
                        <textarea name="note" class="form-control" disabled>{{ $loan->note }}</textarea>
                    </div>
                </div>

                <hr>
                <h5>Books</h5>

                <div class="row"> {{-- gunakan g-4 untuk jarak antar kolom dan baris --}}
                    @forelse ($loan->bookLoans as $item)
                        <div class="col-md-4"> {{-- hanya untuk layout kolom --}}
                            <div class="card position-relative">
                                {{-- 🔴 Bulatan angka pakai Bootstrap --}}
                                <div class="position-absolute top-0 end-0 p-1 bg-danger border border-light rounded">
                                    <div class="text-white d-flex align-items-center justify-content-center"
                                        style="font-size: 12px;">
                                        Total: {{ $item->total }}
                                    </div>
                                </div>
                                <img class="card-img-top"
                                    src="{{ asset('asset/image/book_cover/' . $item->book->cover_image) }}"
                                    onerror="this.onerror=null;this.src='{{ asset('asset/image/no-pictures.png') }}';"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <div class="my-2 d-flex justify-content-end">
                                        <span class="badge badge-info"
                                            style="font-size: medium">{{$item->book->category->name}}</span>
                                    </div>
                                    <h5 class="card-title text-primary">{{$item->book->title}}</h5>
                                    <p class="card-text">Code : <span class="text-secondary">{{$item->book->code}}</span></p>
                                    <p class="card-text text-primary">Author : {{$item->book->author}}</p>
                                    <p class="card-text text-primary">Shelf : {{$item->book->shelf->code}}</p>
                                    <p class="card-text text-primary my-4 text-secondary">
                                        Stock :
                                        {{ empty($item->book->stock) || $item->book->stock == 0 ? 'Tidak ada' : $item->book->stock }}
                                    </p>
                                    <div class="d-flex justify-content-start gap-2">
                                        <a class="btn btn-primary btn-sm btn-icon-text mr-2"
                                            href="{{ route('book.show', $item->book_id) }}">
                                            Detail
                                            <i class="typcn typcn-eye btn-icon-append"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted">
                            <img src="{{ asset('asset/image/noData.jpg') }}" alt="Tidak ada data"
                                style="height: 40vh; width: 60vh; object-fit: contain;">
                        </div>
                    @endforelse
                </div>


                <hr>
                <a href="{{ route('loan.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
@endsection