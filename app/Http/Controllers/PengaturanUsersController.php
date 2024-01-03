<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Application;

class PengaturanUsersController extends Controller
{
    public function index()
    {
        return view('users.setting.index', [
            'app' => Application::all(),
            'title' => 'Pengaturan'
        ]);
    }

    // verify user
    public function verify(Request $request)
    {
        $credentials = $request->validate([
            'usernameverify' => 'required',
            'password' => 'required',
        ]);

        $credentials['username'] = $credentials['usernameverify'];
        unset($credentials['usernameverify']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return back()->with('statusverifysuccess', 'success');
            exit;
        }

        return back()->with('statusverifyfailed', 'failed');
    }

    // set email baru
    public function setemail(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email:dns|unique:users',
        ]);
        User::where('id', auth()->user()->id)
            ->update($validatedData);
        return redirect('/pengaturan')->with('updateEmailUser', 'Email berhasil diupdate!');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'alamat' => 'Max:255',
            'gender' => 'in:Laki-Laki,Perempuan',
            'tanggal_lahir' => '',
            'image' => 'image|file|max:500|dimensions:ratio=1/1'
        ];

        if ($request->username != auth()->user()->username) {
            $rules['username'] = 'required|string|regex:/^[a-zA-Z0-9]+$/|min:5|max:50|unique:users';
        }

        $validatedData = $request->validate($rules, [
            'image.dimensions' => 'The :attribute must have a 1:1 aspect ratio.',
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('profil-images');
        }
        User::where('id', auth()->user()->id)->update($validatedData);
        return redirect('/pengaturan')->with('updateUserBerhasil', 'Data user berhasil diupdate!');
    }

    public function changepassword(Request $request)
    {
        $validatedData = $request->validate([
            'passwordLama' => 'required',
            'passwordBaru' => ['required', 'max:255', Password::min(8)->mixedCase()->letters()->numbers()->symbols(), 'confirmed']
        ]);

        if (Hash::check($validatedData['passwordLama'], auth()->user()->password)) {
            $hashPassword = bcrypt($validatedData['passwordBaru']);
            User::where('id', auth()->user()->id)
                ->update(['password' => $hashPassword]);
            return redirect('/pengaturan')->with('passwordUpdateSuccess', 'Password berhasil diupdate!');
            exit;
        } else {
            return redirect('/pengaturan')->with('passwordLamaSalah', 'Password lama Anda salah!');
        }
    }
}
