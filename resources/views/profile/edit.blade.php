@extends('layouts.layout')

@section('title', 'Edit Profile')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Profile</h4>

            <form action="{{ route('profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="place_of_birth">Place of Birth</label>
                    <input type="text" name="place_of_birth"
                        class="form-control @error('place_of_birth') is-invalid @enderror"
                        value="{{ old('place_of_birth', $profile->place_of_birth) }}">
                    @error('place_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" name="date_of_birth"
                        class="form-control @error('date_of_birth') is-invalid @enderror"
                        value="{{ old('date_of_birth', $profile->date_of_birth) }}">
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                        <option value="">-- Select --</option>
                        <option value="L" {{ old('gender', $profile->gender) == 'L' ? 'selected' : '' }}>Male</option>
                        <option value="P" {{ old('gender', $profile->gender) == 'P' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                        value="{{ old('phone_number', $profile->phone_number) }}">
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" rows="3"
                        class="form-control @error('address') is-invalid @enderror">{{ old('address', $profile->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea name="bio" rows="3"
                        class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $profile->bio) }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Profile Image</label>
                    @if($profile->image)
                        <div class="mb-2">
                            <img src="{{ asset('asset/image/profile_image/' . $profile->image) }}" alt="Profile Image" width="100">
                        </div>
                    @endif
                    <input type="file" name="image" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('profile.index') }}" class="btn btn-light mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection