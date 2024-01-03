<?php

use Illuminate\Support\Facades\Route;
use App\Models\Application;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\NilaiQuizController;
use App\Http\Controllers\PengaturanUsersController;
use App\Http\Controllers\AdminDataQuizController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPengaturanController;
use App\Http\Controllers\AdminPenggunaController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\DiscussController;
use App\Http\Controllers\MateriController;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Thread;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Homepage
Route::get('/',  function () {
  return view('home', [
    'users' => User::where('is_admin', 0)->get()->count(),
    'quizzes' => Quiz::all()->count(),
    'threads' => Thread::all()->count(),
    'app' => Application::first(),
    'title' => Application::first()->name_app . '-' . Application::first()->description_app
  ]);
});

// login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/logout', function () {
  return redirect('/');
});

// Users
// register users
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

// materi users
Route::get('/materi', [MateriController::class, 'show'])->middleware('member');

// quiz users
Route::get('/quiz', [QuizController::class, 'index'])->middleware('member');
Route::post('/quiz', [QuizController::class, 'store'])->middleware('member');
Route::get('/quiz/start/{quiz:slug}', [QuizController::class, 'show'])->middleware('member');
Route::post('/quiz/start/sejarah-aksara-jawa', function () {
  return view('dokumentasi.start', [
    'app' => Application::all(),
    'title' => 'Dokumentasi'
  ]);
});

// nilai users
Route::get('/nilai/search', [NilaiQuizController::class, 'search'])->middleware('member');
Route::get('/nilai', [NilaiQuizController::class, 'index'])->middleware('member');
Route::get('/nilai/details/{nilai:code}', [NilaiQuizController::class, 'show'])->middleware('member');
Route::post('/nilai/delete/{result:code}', [NilaiQuizController::class, 'destroy'])->middleware('member');

// Setting users
Route::get('/pengaturan', [PengaturanUsersController::class, 'index'])->middleware('member');
Route::post('/pengaturan', [PengaturanUsersController::class, 'store'])->middleware('member');
Route::post('/pengaturan/verify', [PengaturanUsersController::class, 'verify'])->middleware('member');
Route::post('/pengaturan/setemail', [PengaturanUsersController::class, 'setemail'])->middleware('member');
Route::get('/pengaturan/setemail', function () {
  return back();
})->middleware('member');
Route::get('/pengaturan/verify', function () {
  return back();
})->middleware('member');
Route::post('/pengaturan/changepassword', [PengaturanUsersController::class, 'changepassword'])->middleware('member');
Route::get('/pengaturan/changepassword', function () {
  return back();
})->middleware('member');
//App
// Documentation App
Route::get('/docs/v1', function () {
  return view('dokumentasi.index', [
    'app' => Application::first(),
    'title' => 'Dokumentasi'
  ]);
});
Route::get('/docs/v1/start', function () {
  return view('dokumentasi.start', [
    'app' => Application::first(),
    'title' => 'Dokumentasi'
  ]);
});


// admin
// admin materi
Route::get('/admin/data-materi', [MateriController::class, 'index'])->middleware('admin');
Route::post('/admin/data-materi', [MateriController::class, 'store'])->middleware('admin');
Route::post('/admin/data-materi/update', [MateriController::class, 'update'])->middleware('admin');
Route::get('/admin/data-materi/update', function () {
  return back();
})->middleware('admin');
Route::post('/admin/data-materi/delete', [MateriController::class, 'destroy'])->middleware('admin');
Route::get('/admin/data-materi/delete', function () {
  return back();
})->middleware('admin');
Route::get('/admin/data-materi/search', [MateriController::class, 'search'])->middleware('admin');

//admin quiz
Route::get('/admin/dashboard',  [AdminDashboardController::class, 'index'])->middleware('admin');

Route::get('/admin/data-quiz', [AdminDataQuizController::class, 'index'])->middleware('admin');
Route::get('/admin/data-quiz/search', [AdminDataQuizController::class, 'search'])->middleware('admin');
Route::post('/admin/data-quiz', [AdminDataQuizController::class, 'store'])->middleware('admin');
Route::post('/admin/data-quiz/update', [AdminDataQuizController::class, 'update'])->middleware('admin');
Route::post('/admin/data-quiz/delete/{quiz:slug}', [AdminDataQuizController::class, 'destroy'])->middleware('admin');
Route::get('/admin/data-quiz/delete/{quiz:slug}', function () {
  return back();
})->middleware('admin');
Route::get('/admin/data-quiz/update', function () {
  return back();
})->middleware('admin');

// admin quiz > q&a
Route::get('/admin/data-quiz/q&a/{quiz:slug}', [AdminDataQuizController::class, 'show'])->middleware('admin');
Route::post('/admin/data-quiz/q&a/{quiz:slug}', [AdminDataQuizController::class, 'addquestion'])->middleware('admin');
Route::post('/admin/data-quiz/q&a/delete/{question:id}', [AdminDataQuizController::class, 'destroyquestion'])->middleware('admin');
Route::post('/admin/data-quiz/getanswer', [AdminDataQuizController::class, 'getanswer'])->middleware('admin');
Route::get('/admin/data-quiz/q&a/delete/{question:id}', function () {
  return back();
})->middleware('admin');
Route::post('/admin/data-quiz/q&a/update/question', [AdminDataQuizController::class, 'updatequestion'])->middleware('admin');
Route::get('/admin/data-quiz/q&a/update/question', function () {
  return back();
})->middleware('admin');
Route::get('/admin/data-quiz/q&a/{quiz:slug}/search', [AdminDataQuizController::class, 'searchquestion'])->middleware('admin');

// Setting admin
Route::get('/admin/pengaturan', [AdminPengaturanController::class, 'index'])->middleware('admin');
Route::post('/admin/pengaturan', [AdminPengaturanController::class, 'store'])->middleware('admin');
Route::post('/admin/pengaturan/verify', [AdminPengaturanController::class, 'verify'])->middleware('admin');
Route::post('/admin/pengaturan/setemail', [AdminPengaturanController::class, 'setemail'])->middleware('admin');
Route::get('/admin/pengaturan/setemail', function () {
  return back();
})->middleware('admin');
Route::get('/admin/pengaturan/verify', function () {
  return back();
})->middleware('admin');
Route::post('/admin/pengaturan/changepassword', [AdminPengaturanController::class, 'changepassword'])->middleware('admin');
Route::get('/admin/pengaturan/changepassword', function () {
  return back();
})->middleware('admin');
Route::post('/admin/pengaturan/app', [AdminPengaturanController::class, 'updateapp'])->middleware('admin');
Route::get('/admin/pengaturan/app', function () {
  return back();
})->middleware('admin');

//kelola pengguna 
Route::get('/admin/pengguna', [AdminPenggunaController::class, 'index'])->middleware('admin');
Route::post('/admin/pengguna', [AdminPenggunaController::class, 'store'])->middleware('admin');
Route::post('/admin/pengguna/edit', [AdminPenggunaController::class, 'update'])->middleware('admin');
Route::get('/admin/pengguna/edit', function () {
  return back();
})->middleware('admin');
Route::post('/admin/pengguna/getuser', [AdminPenggunaController::class, 'getuser'])->middleware('admin');
Route::get('/admin/pengguna/getuser', function () {
  return back();
})->middleware('admin');
Route::post('/admin/pengguna/delete/{user:id}', [AdminPenggunaController::class, 'destroy'])->middleware('admin');
Route::get('/admin/pengguna/delete/{user:id}', function () {
  return back();
})->middleware('admin');
Route::get('/admin/pengguna/search', [AdminPenggunaController::class, 'search'])->middleware('admin');

// laporan
Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->middleware('admin');
Route::get('/admin/laporan/{quiz:slug}', [AdminLaporanController::class, 'show'])->middleware('admin');
Route::get('/admin/laporan/details/{nilai:code}', [AdminLaporanController::class, 'details'])->middleware('admin');
Route::get('/admin/laporan/{quiz:slug}/search', [AdminLaporanController::class, 'searchAccess'])->middleware('admin');

// convert aksara
Route::get('/admin/ubah-teks', function () {
  return view('admin.ubahteks.index', [
    'app' => Application::all(),
    'title' => 'Ubah Teks Jadi Aksara Jawa',
  ]);
})->middleware('admin');


// Access Admin & Users
// Discuss Thread
Route::get('/view/discuss', [DiscussController::class, 'index'])->middleware('auth');
Route::post('/view/discuss', [DiscussController::class, 'store'])->middleware('auth');
Route::post('/view/discuss/thread/delete', [DiscussController::class, 'deleteThread'])->middleware('auth');
Route::get('/view/discuss/thread/delete', function () {
  return back();
})->middleware('auth');
Route::get('/view/discuss/search', [DiscussController::class, 'search'])->middleware('auth');


// Like & Unlike Thread
Route::post('/view/discuss/like', [DiscussController::class, 'like'])->middleware('auth');
Route::get('/view/discuss/like', function () {
  return back();
})->middleware('auth');

// Comment Thread
Route::get('/view/discuss/thread/{thread}', [DiscussController::class, 'details'])->middleware('auth');
Route::post('/view/discuss/thread/{thread}', [DiscussController::class, 'comment'])->middleware('auth');
Route::post('/view/discuss/comment/delete/{comment}', [DiscussController::class, 'destroy'])->middleware('auth');
Route::get('/view/discuss/comment/delete/{comment}', function () {
  return back();
})->middleware('auth');
