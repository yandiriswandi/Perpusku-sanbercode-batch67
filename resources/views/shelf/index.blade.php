@extends('layouts.layout')
@section('title')
    Shelf
@endsection
@section('content')
    <div class="card p-4">
        @if (Auth::user()->role == 'admin')
            <div class="">
                <a type="button" class="btn btn-success btn-sm btn-icon-text" href="{{route('shelf.create')}}">
                    Add Data
                    <i class="typcn typcn-plus btn-icon-append"></i>
                </a>
            </div>
        @endif
        <hr>
        <div class="table-responsive pt-3">
            <table id="data-table" class="table table-hover project-orders-table">
                <thead>
                    <tr>
                        <th class="ml-5">No.</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shelf as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                {{$item->code}}
                            </td>
                            <td>{{$item->name}}</td>
                            <td class="text-truncate" style="max-width: 200px;">{{ $item->description }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- Edit Button -->
                                    @if (Auth::user()->role == 'admin')
                                        <a class="btn btn-warning btn-sm btn-icon-text mr-2 text-light"
                                            href="{{ route('shelf.edit', $item->id) }}">
                                            Edit
                                            <i class="typcn typcn-edit btn-icon-append"></i>
                                        </a>
                                    @endif
                                    <!-- Detail Button -->
                                    <a class="btn btn-primary btn-sm btn-icon-text mr-2"
                                        href="{{ route('shelf.show', $item->id) }}">
                                        Detail
                                        <i class="typcn typcn-eye btn-icon-append"></i>
                                    </a>

                                    <!-- Delete Button (in div, not directly in flex) -->
                                    @if (Auth::user()->role == 'admin')
                                        <div class="d-inline-block">
                                            <form id="delete-form-{{ $item->id }}" action="{{ route('shelf.destroy', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-icon-text"
                                                    onclick="confirmDelete({{ $item->id }})">
                                                    Delete
                                                    <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">
                                <img src="{{ asset('asset/image/noData.jpg') }}" alt="Tidak ada data"
                                    style="height: 20vh; width: 40vh; object-fit: contain;">
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection