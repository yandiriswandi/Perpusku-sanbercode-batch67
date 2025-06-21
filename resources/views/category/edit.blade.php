@extends('layouts.layout')

@section('title')
    Edit Category
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" method="POST" action="{{route('category.update', $category->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label ">Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                            id="exampleInputUsername2" placeholder="Code" name="code"
                            value="{{ old('code', $category->code) }}">
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
                            placeholder="Name" name="name" value="{{ old('name', $category->name) }}">
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
                            name="description">{{ old('description', $category->description) }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-light" onclick="history.back()" type="button">Cancel</button>
            </form>
        </div>
    </div>
@endsection