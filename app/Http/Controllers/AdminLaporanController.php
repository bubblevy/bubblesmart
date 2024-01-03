<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\Answer_user;
use App\Models\Question;


class AdminLaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index', [
            'app' => Application::all(),
            'title' => 'Laporan Data Akses Quiz',
            'reports' => Quiz::with(['result'])->latest()->paginate(10)
        ]);
    }

    public function show(Quiz $quiz)
    {
        $query = Result::with(['quiz', 'answer_user']);
        if (request('filter') === 'tertinggi') {
            $query = $query->orderBy('score', 'desc');
        }
        if (request('filter') === 'terendah') {
            $query = $query->orderBy('score', 'asc');
        }

        return view('admin.laporan.access', [
            'app' => Application::all(),
            'title' => 'Laporan Data Akses Quiz',
            'dataquiz' => $quiz,
            'reports' => $query->where('quiz_id', $quiz->id)->with(['user', 'answer_user', 'quiz'])->latest()->paginate(10)
        ]);
    }

    public function details(Result $nilai)
    {
        $quiz_id = Result::find($nilai->id)->quiz_id;
        return view('admin.laporan.details', [
            'app' => Application::all(),
            'title' => 'Detail Quiz',
            'dataresult' => Result::find($nilai->id),
            'dataquiz' => Quiz::find($quiz_id),
            'correct' => Answer_user::where('result_id', $nilai->id)->where('correct', 1),
            'totalScore' => Result::find($nilai->id)->score,
            'scores' => Answer_user::with(['answer', 'result', 'user', 'question'])->where('result_id', $nilai->id)->get(),
            'questions' => Question::with(['answer'])->where('quiz_id', $quiz_id)->get()
        ]);
    }

    public function searchAccess(Quiz $quiz)
    {
        if (request('q') === null) {
            return redirect('/admin/laporan/' . $quiz->slug);
            exit;
        }

        return view('admin.laporan.search_access', [
            'app' => Application::all(),
            'title' => 'Laporan Data Akses Quiz',
            'dataquiz' => $quiz,
            'reports' => Result::where('quiz_id', $quiz->id)->with(['user', 'answer_user', 'quiz'])->latest()->searchingAccess(request('q'))->paginate(10)
        ]);
    }
}
