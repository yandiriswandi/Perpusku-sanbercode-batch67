@extends('layouts.layout')

@section('title')
    Detail Category
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <img src="{{asset('asset/image/book_cover/' . $book->cover_image)}}"
                    onerror="this.onerror=null;this.src='{{ asset('asset/image/no-pictures.png') }}';" alt="image">
            </div>
            <div class="my-2 d-flex justify-content-end">
                <span class="badge badge-info" style="font-size: medium">{{$book->category->name}}</span>
            </div>
            <h5 class="card-title text-primary">{{$book->title}}</h5>
            <p class="card-text">Code : <span class="text-secondary">{{$book->code}}</span></p>
            <p class="card-text text-primary">Author : {{$book->author}}</p>
            <p class="card-text text-primary">Shelf : {{$book->shelf->code}}</p>
            <p class="card-text text-secondary">{{$book->description}}</p>
            <p class="card-text text-primary my-4 text-light badge badge-warning">
                Stock : {{ empty($book->stock) || $book->stock == 0 ? 'Tidak ada' : $book->stock }}
            </p>
        </div>
    </div>
@endsection