<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view('user.index', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:users,code',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed', // Akan mencocokkan dengan `password_confirmation`
                'min:6',     // Minimal 6 karakter (opsional)
                'regex:/^\S*$/u' // Tidak boleh ada spasi
            ],
            'role' => 'required|in:admin,user',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->code = $request->code;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/user')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return view('user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:users,code,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->code = $request->code;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();
        return redirect('/user')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        //contoh menggunakan route name
        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus!');
    }
}
