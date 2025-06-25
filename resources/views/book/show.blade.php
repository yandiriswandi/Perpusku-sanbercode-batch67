@extends('layouts.layout')

@section('title')
    Detail Book
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
            <h6>List Comments</h6>
            @forelse ($book->comments as $comment)
                <div class="card my-2">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ $comment->user->name }}</span>

                        @if (Auth::user()->id === $comment->user_id)
                            <button class="btn btn-sm btn-outline-secondary" onclick="toggleEditForm({{ $comment->id }})">
                                Edit
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        {{-- Show comment --}}
                        <p class="card-text" id="comment-content-{{ $comment->id }}">
                            {{ $comment->content }}
                        </p>

                        {{-- Hidden edit form --}}
                        <form action="{{ route('comment.update', $comment->id) }}" method="POST"
                            id="edit-form-{{ $comment->id }}" style="display: none;">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <textarea name="content" class="form-control" rows="3">{{ $comment->content }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Save</button>
                            <button type="button" class="btn btn-sm btn-secondary mt-2"
                                onclick="toggleEditForm({{ $comment->id }})">
                                Cancel
                            </button>
                        </form>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <p>Comment not found</p>
            @endforelse

            <hr>
            <h6>Add Comments</h6>
            <form action="{{route('comment.store', $book->id)}}" method="POST">
                @csrf
                <textarea name="content" class="form-control" id=""></textarea>
                <button class="btn btn-primary my-2" type="submit">Send</button>
            </form>
        </div>
    </div>
    <script>
        function toggleEditForm(id) {
            const form = document.getElementById('edit-form-' + id);
            const content = document.getElementById('comment-content-' + id);

            if (form.style.display === 'none') {
                form.style.display = 'block';
                content.style.display = 'none';
            } else {
                form.style.display = 'none';
                content.style.display = 'block';
            }
        }
    </script>

@endsection