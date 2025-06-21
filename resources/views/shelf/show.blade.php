@extends('layouts.layout')

@section('title')
    Edit shelf
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" method="POST" action="{{route('shelf.update', $shelf->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label ">Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                            id="exampleInputUsername2" placeholder="Code" name="code"
                            value="{{ old('code', $shelf->code) }}" readonly>
                        @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail2"
                            placeholder="Name" name="name" value="{{ old('name', $shelf->name) }}" readonly>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" id="exampleInputMobile" placeholder="Description"
                            name="description" readonly>{{ old('description', $shelf->description) }}</textarea>
                    </div>
                </div>
                <hr>
                <h5>Books</h5>

                <div class="row"> {{-- gunakan g-4 untuk jarak antar kolom dan baris --}}
                    @forelse ($shelf->book as $item)
                        <div class="col-md-4"> {{-- hanya untuk layout kolom --}}
                            <div class="card position-relative">
                                <img class="card-img-top" src="{{ asset('asset/image/book_cover/' . $item->cover_image) }}"
                                    onerror="this.onerror=null;this.src='{{ asset('asset/image/no-pictures.png') }}';"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <div class="my-2 d-flex justify-content-end">
                                        <span class="badge badge-info"
                                            style="font-size: medium">{{$item->category->name}}</span>
                                    </div>
                                    <h5 class="card-title text-primary">{{$item->title}}</h5>
                                    <p class="card-text">Code : <span class="text-secondary">{{$item->code}}</span></p>
                                    <p class="card-text text-primary">Author : {{$item->author}}</p>
                                    <p class="card-text text-primary">Shelf : {{$item->shelf->code}}</p>
                                    <p class="card-text text-primary my-4 text-secondary">
                                        Stock :
                                        {{ empty($item->stock) || $item->stock == 0 ? 'Tidak ada' : $item->stock }}
                                    </p>
                                    <div class="d-flex justify-content-start gap-2">
                                        <a class="btn btn-primary btn-sm btn-icon-text mr-2"
                                            href="{{ route('book.show', $item->id) }}">
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
                <button class="btn btn-light" onclick="history.back()" type="button">Cancel</button>
            </form>
        </div>
    </div>
@endsection