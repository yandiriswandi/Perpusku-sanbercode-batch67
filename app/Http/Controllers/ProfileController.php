<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::with('user')->get();
        return view('profile.index', compact('profiles'));
    }

    public function create()
    {
        return view('profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'bio' => 'nullable|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'gender' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $newImageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('asset/image/profile_image'), $newImageName);
        } else {
            $newImageName = null; // atau bisa pakai default image jika perlu
        }
        $data['image'] = $newImageName;

        Profile::create($data);

        return redirect()->route('dashboard')->with('success', 'Profile created successfully');
    }

    public function show(Profile $profile)
    {
        return view('profile.show', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'bio' => 'nullable|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'gender' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image'); // ambil semua kecuali image dulu

        if ($request->hasFile('image')) {
            // Hapus gambar lama kalau ada
            if ($profile->image) {
                $oldImagePath = public_path('asset/image/profile_image/' . $profile->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Simpan gambar baru
            $newImageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('asset/image/profile_image'), $newImageName);

            // Simpan nama file ke DB
            $data['image'] = $newImageName;
        } else {
            $data['image'] = $profile->image; // tetap gunakan gambar lama
        }

        $profile->update($data);

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully');
    }

    public function destroy(Profile $profile)
    {
        if ($profile->image) {
            Storage::disk('public')->delete($profile->image);
        }
        $profile->delete();

        return redirect()->route('profile.index')->with('success', 'Profile deleted successfully');
    }
}
