<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4|max:255|unique:users',
            'password' => 'required|min:5|max:255',
            'nama' => 'required',
        ]);

        $user = ['name' => $request->name, 'password' => Hash::make($request->password)];
        $data = User::create($user);

        $mahasiswa = ['nama' => $request->nama, 'jurusan' => $request->jurusan, 'user_id' => $data->id];
        Mahasiswa::create($mahasiswa);

        $request->session()->flash('success', 'User has been created! You can login now');
        return redirect()->route('login-mahasiswa');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $user = User::where($fieldType, $request->username);
        if ($user->count() > 0) {
            if (Auth::attempt([$fieldType => $request->username, 'password' => $request->password])) {
                return redirect()->route('dashboard-mahasiswa');
            } else {
                $request->session()->flash('error', 'Username or password wrong, try again!');
                return redirect()->route('login-mahasiswa');
            }
        } else {
            $request->session()->flash('error', 'User not registered, please register!');
            return redirect()->route('login-mahasiswa');
        }
    }

    public function logout()
    {
        $id = auth()->user()->role;
        Auth::logout();
        if ($id === 3)
            return redirect()->route('login-mahasiswa');
        else
            return redirect()->route('login-dosen');
    }
}
