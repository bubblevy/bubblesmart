<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Application;

class MateriController extends Controller
{
    public function index()
    {
        return view('admin.datamateri.index', [
            'app' => Application::all(),
            'materis' => Materi::latest()->paginate(10),
            'title' => 'Data Materi'
        ]);
    }

    // users show
    public function show()
    {
        return view('users.materi.index', [
            'app' => Application::all(),
            'materis' => Materi::all(),
            'title' => 'Materi'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|file|max:500',
            'title' => 'required|max:255|string',
            'category' => 'required|in:huruf,pasangan,sandhangan',
            'audio' => 'mimes:mp3|max:250'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('aksara');
        }
        if ($request->file('audio')) {
            $validatedData['audio'] = $request->file('audio')->store('audio');
        }

        Materi::create($validatedData);
        return back()->with('addMateriSuccess', 'Materi berhasil ditambah!');
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'imageEdit' => 'image|file|max:500',
            'titleEdit' => 'max:255|string',
            'categoryEdit' => 'required|in:huruf,pasangan,sandhangan',
            'audioEdit' => 'mimes:mp3|max:250'
        ], [
            'imageEdit.image' => 'The image field must be an image.',
            'imageEdit.max' => 'The image field must not be greater than 500 kilobytes.',
            'audioEdit.mimes' => 'The audio field must be a file of type: mp3',
            'audioEdit.max' => 'The audio field must not be greater than 250 kilobytes.',
        ]);
        if ($request->file('imageEdit')) {
            $validatedData['imageEdit'] = $request->file('imageEdit')->store('aksara');
            $validatedData['image'] = $validatedData['imageEdit'];
            unset($validatedData['imageEdit']);
        }

        if ($request->file('audioEdit')) {
            $validatedData['audioEdit'] = $request->file('audioEdit')->store('audio');
            $validatedData['audio'] = $validatedData['audioEdit'];
            unset($validatedData['audioEdit']);
        }
        $validatedData['title'] = $validatedData['titleEdit'];
        $validatedData['category'] = $validatedData['categoryEdit'];
        unset($validatedData['titleEdit']);
        unset($validatedData['categoryEdit']);
        Materi::where('id', decrypt($request->codeMateri))->update($validatedData);
        return back()->with('editMateriSuccess', 'Materi berhasil diupdate!');
    }

    public function destroy(Request $request)
    {
        Materi::destroy(decrypt($request->codeMateri));
        return back()->with('deleteMateriSuccess', 'Materi berhasil dihapus!');
    }

    public function search()
    {
        if (request('q') === null) {
            return redirect('/admin/data-materi');
            exit;
        }

        return view('admin.datamateri.search', [
            'app' => Application::all(),
            'title' => 'Data Materi',
            'materis' => Materi::latest()->searching(request('q'))->paginate(10)
        ]);
    }
}
