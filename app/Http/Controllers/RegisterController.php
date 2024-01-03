<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use App\Models\Application;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('register.index', [
            'app' => Application::all(),
            'title' => 'Register'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'username' => 'required|string|regex:/^[a-zA-Z0-9]+$/|min:5|max:50|unique:users',
            'name' => 'required|string|max:100',
            'email' => 'required|email:dns|unique:users',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'password' => ['required', 'max:255', Password::min(8)->mixedCase()->letters()->numbers()->symbols(), 'confirmed'],
            'terms' => 'required'
        ]);

        if ($request->gender == 'Perempuan') {
            $validatedData['image'] = 'profil-images/girl.jpeg';
        } else {
            $validatedData['image'] = 'profil-images/man.jpeg';
        }

        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);

        return redirect('/login')->with('registerBerhasil', 'Registrasi akun anda berhasil!');
    }
}
