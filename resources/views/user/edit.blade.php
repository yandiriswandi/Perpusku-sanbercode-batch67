@extends('layouts.layout')

@section('title')
    Edit User
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form class="forms-sample" method="POST" action="{{route('user.update', $user->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label ">Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                            id="exampleInputUsername2" placeholder="Code" name="code"
                            value="{{ old('code', $user->code) }}">
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
                            placeholder="Name" name="name" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Email" name="email" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="role" class="col-sm-3 col-form-label">Role</label>
                    <div class="col-sm-9">
                        <select class="js-example-basic-single form-control @error('role') is-invalid @enderror" name="role"
                            id="role">
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                            <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>User
                            </option>
                        </select>

                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Password" value="{{ old('password', $user->password) }}">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="typcn typcn-eye" id="icon-password"></i>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" value="{{ old('password_confirmation') }}">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-secondary" type="button"
                                    onclick="togglePassword('password_confirmation')">
                                    <i class="typcn typcn-eye" id="icon-password_confirmation"></i>
                                </button>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div> --}}
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-light" onclick="history.back()" type="button">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById('icon-' + fieldId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('typcn-eye');
                icon.classList.add('typcn-eye-outline');
            } else {
                input.type = "password";
                icon.classList.remove('typcn-eye-outline');
                icon.classList.add('typcn-eye');
            }
        }
    </script>


@endsection