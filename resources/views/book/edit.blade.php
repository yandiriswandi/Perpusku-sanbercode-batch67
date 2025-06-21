@extends('layouts.layout')

@section('title')
    Edit Book
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" method="POST" action="{{route('book.update', $book->id)}}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputUsername2">Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                            id="exampleInputUsername2" placeholder="Code" name="code"
                            value="{{ old('code', $book->code) }}">
                        @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="year">ISBN</label>
                        <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn"
                            placeholder="ISBN" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                        @error('isbn')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="title">Title</label>

                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            placeholder="Title" name="title" value="{{ old('title', $book->title) }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="category_id">Category</label>
                        <select
                            class="js-example-basic-single w-100 form-control @error('category_id') is-invalid @enderror"
                            name="category_id" id="category_id">

                            @forelse ($category as $item)
                                <option value="{{ $item->id }}" {{ (old('category_id') ?? ($book->category_id ?? '')) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @empty
                                <option value="">Data tidak ditemukan</option>
                            @endforelse
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="shelf_id">Shelf</label>
                        <select class="js-example-basic-single w-100 form-control @error('shelf_id') is-invalid @enderror"
                            name="shelf_id">
                            @forelse ($shelf as $item)
                                <option value="{{$item->id}}" {{ (old('shelf_id') ?? ($book->shelf_id ?? '')) == $item->id ? 'selected' : '' }}>{{$item->code}} ({{$item->name}})</option>
                            @empty
                                <option>Data tidak ditemukan</option>
                            @endforelse
                        </select>

                        @error('shelf_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail2">Author</label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror"
                            id="exampleInputEmail2" placeholder="Author" name="author"
                            value="{{ old('author', $book->author) }}">
                        @error('author')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="publisher">Publisher</label>
                        <input type="text" class="form-control @error('publisher') is-invalid @enderror"
                            id="exampleInputEmail2" placeholder="Publisher" name="publisher"
                            value="{{ old('publisher', $book->publisher) }}">
                        @error('publisher')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="year_published">Year Published</label>
                        <input type="number" class="form-control @error('year_published') is-invalid @enderror"
                            id="year_published" placeholder="Year Published" name="year_published"
                            value="{{ old('year_published', $book->year_published) }}">
                        @error('year_published')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock"
                            placeholder="Stock" name="stock" value="{{ old('stock', $book->stock) }}">
                        @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>File upload</label>
                        <input type="file" name="cover_image" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="description">Description</label>
                        <textarea type="text" class="form-control" id="description" placeholder="Description"
                            name="description">{{ old('description', $book->description) }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-light" onclick="history.back()" type="button">Cancel</button>
            </form>
        </div>
    </div>

@endsection