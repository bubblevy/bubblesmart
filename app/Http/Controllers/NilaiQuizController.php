<?php

namespace App\Http\Controllers;

use App\Models\Answer_user;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Application;

class NilaiQuizController extends Controller
{
    public function index()
    {
        $query = Result::with(['quiz', 'answer_user']);
        if (request('filter') === 'teratas') {
            $query = $query->orderBy('score', 'desc');
        }
        if (request('filter') === 'terendah') {
            $query = $query->orderBy('score', 'asc');
        }
        return view('users.nilai.index', [
            'app' => Application::all(),
            'title' => 'Nilai Quiz',
            'histories' => $query->where('user_id', auth()->user()->id)->latest()->paginate(10)
        ]);
    }

    public function search()
    {
        if (request('q') === null) {
            return redirect('/nilai');
            exit;
        }
        return view('users.nilai.search', [
            'app' => Application::all(),
            'title' => 'Nilai Quiz',
            'histories' => Result::with(['quiz', 'answer_user'])->where('user_id', auth()->user()->id)->latest()->searching(request('q'))->paginate(10)
        ]);
    }

    public function show(Result $nilai)
    {
        $quiz_id = Result::find($nilai->id)->quiz_id;
        return view('users.nilai.detail', [
            'app' => Application::all(),
            'title' => 'Detail Quiz',
            'tanggalMengerjakanQuiz' => Result::find($nilai->id)->created_at,
            'titleQuiz' => Quiz::find($quiz_id)->title,
            'correct' => Answer_user::where('result_id', $nilai->id)->where('correct', 1),
            'totalScore' => Result::find($nilai->id)->score,
            'scores' => Answer_user::with(['answer', 'result', 'user', 'question'])->where('result_id', $nilai->id)->get(),
            'questions' => Question::with(['answer'])->where('quiz_id', $quiz_id)->get()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        Answer_user::where('result_id', $result->id)->delete();
        Result::destroy($result->id);
        return redirect('/nilai')->with('messages', 'Histori quiz berhasil dihapus!');
    }
}
