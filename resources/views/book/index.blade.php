@extends('layouts.layout')
@section('title')
    Book
@endsection
@section('content')
    <div class="card p-4">
        @if (Auth::user()->role == 'admin')

            <div class="">
                <a type="button" class="btn btn-success btn-sm btn-icon-text" href="{{route('book.create')}}">
                    Add Data
                    <i class="typcn typcn-plus btn-icon-append"></i>
                </a>
            </div>
        @endif
        <hr>
        <form method="GET" action="{{ route('book.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Cari buku...">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <div class="row"> {{-- gunakan g-4 untuk jarak antar kolom dan baris --}}
            @forelse ($book as $item)
                <div class="col-md-3"> {{-- hanya untuk layout kolom --}}
                    <div class="card h-100"> {{-- styling di sini --}}
                        <img class="card-img-top" src="{{ asset('asset/image/book_cover/' . $item->cover_image) }}"
                            onerror="this.onerror=null;this.src='{{ asset('asset/image/no-pictures.png') }}';"
                            alt="Card image cap">
                        <div class="card-body">
                            <div class="my-2 d-flex justify-content-end">
                                <span class="badge badge-info" style="font-size: medium">{{$item->category->name}}</span>
                            </div>
                            <h5 class="card-title text-primary">{{$item->title}}</h5>
                            <p class="card-text">Code : <span class="text-secondary">{{$item->code}}</span></p>
                            <p class="card-text text-primary">Author : {{$item->author}}</p>
                            <p class="card-text text-primary">Shelf : {{$item->shelf->code}}</p>
                            <p class="card-text text-primary my-4 text-secondary">
                                Stock : {{ empty($item->stock) || $item->stock == 0 ? 'Tidak ada' : $item->stock }}
                            </p>
                            <div class="d-flex justify-content-start gap-2">
                                @if (Auth::user()->role == 'admin')

                                    <a class="btn btn-warning btn-sm btn-icon-text mr-2 text-light"
                                        href="{{ route('book.edit', $item->id) }}">
                                        Edit
                                        <i class="typcn typcn-edit btn-icon-append"></i>
                                    </a>
                                @endif
                                <a class="btn btn-primary btn-sm btn-icon-text mr-2" href="{{ route('book.show', $item->id) }}">
                                    Detail
                                    <i class="typcn typcn-eye btn-icon-append"></i>
                                </a>
                                @if (Auth::user()->role == 'admin')
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('book.destroy', $item->id) }}"
                                        method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-icon-text"
                                            onclick="confirmDelete({{ $item->id }})">
                                            Delete
                                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                        </button>
                                    </form>
                                @endif
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

        <div class="d-flex justify-content-center mt-4">
            {{ $book->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection