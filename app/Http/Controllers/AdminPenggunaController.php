<?php

namespace App\Http\Controllers;

use App\Models\Answer_user;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\User;
use App\Models\Result;
use Illuminate\Validation\Rules\Password;

class AdminPenggunaController extends Controller
{
    public function index()
    {
        return view('admin.pengguna.index', [
            'app' => Application::all(),
            'title' => 'Data Pengguna',
            'users' => User::latest()->where('is_admin', false)->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|regex:/^[a-zA-Z0-9]+$/|min:5|max:50|unique:users',
            'name' => 'required|string|max:100',
            'email' => 'required|email:dns|unique:users',
            'image' => 'image|file|max:500|dimensions:ratio=1/1',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'password' => ['required', 'max:255', Password::min(8)->mixedCase()->letters()->numbers()->symbols()]
        ], [
            'image.dimensions' => 'The :attribute must have a 1:1 aspect ratio.',
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('profil-images');
        } else {
            if ($request->gender == 'Perempuan') {
                $validatedData['image'] = 'profil-images/girl.jpeg';
            } else {
                $validatedData['image'] = 'profil-images/man.jpeg';
            }
        }

        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);

        return back()->with('adduserSuccess', 'Pengguna berhasil ditambah!');
    }



    public function update(Request $request)
    {
        try {
            $id_user = decrypt($request->codeUser);
            $data = User::where('id', $id_user)->first();

            $rules = [
                'name' => 'required|string|max:100',
                'image' => 'image|file|max:500|dimensions:ratio=1/1',
                'gender' => 'required|in:Laki-Laki,Perempuan',
            ];

            if ($request->username != $data->username) {
                $rules['username'] = 'required|string|regex:/^[a-zA-Z0-9]+$/|min:5|max:50|unique:users';
            }

            if ($request->email != $data->email) {
                $rules['email'] = 'required|email:dns|unique:users';
            }

            if ($request->password) {
                $rules['password'] = ['required', 'max:255', Password::min(8)->mixedCase()->letters()->numbers()->symbols()];
            }

            $validatedData = $request->validate($rules, [
                'image.dimensions' => 'The image must have a 1:1 aspect ratio.'
            ]);

            if ($request->password) {
                $validatedData['password'] = bcrypt($request->password);
            }

            if ($request->image) {
                $validatedData['image'] = $request->file('image')->store('profil-images');
            }

            User::where('id', $id_user)->update($validatedData);

            return back()->with('updateUserSuccess', 'Pengguna berhasil diupdate!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            session()->flash('validationErrors', $errors);
            return redirect()->back()->withInput();
        }
    }

    // ajax edit pengguna
    public function getuser(Request $request)
    {
        $id = decrypt($request->id);
        $data = User::where('id', $id)->get();
        return $data;
    }

    public function destroy(User $user)
    {
        Answer_user::where('user_id', $user->id)->delete();
        Result::where('user_id', $user->id)->delete();
        User::destroy($user->id);
        return back()->with('deleteUserSuccess', 'Pengguna berhasil dihapus!');
    }

    public function search()
    {
        if (request('q') === null) {
            return redirect('/admin/pengguna');
            exit;
        }

        return view('admin.pengguna.search', [
            'app' => Application::all(),
            'title' => 'Data Pengguna',
            'users' => User::latest()->where('is_admin', false)->searching(request('q'))->paginate(10)
        ]);
    }
}
