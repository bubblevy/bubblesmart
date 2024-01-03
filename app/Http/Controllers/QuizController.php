<?php

namespace App\Http\Controllers;

use App\Models\Answer_user;
use App\Models\Question;
use App\Models\Result;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\Application;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.quiz.index', [
            'app' => Application::all(),
            'title' => 'Quiz',
            'quizzes' => Quiz::where('status', 'Aktif')->latest()->paginate(6)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $idQuiz = decrypt($request->quizCode);
        DB::beginTransaction();
        try {
            $totalScore = 0;
            $newRecord = Result::create([
                'user_id' => auth()->user()->id,
                'score' => 0,
                'quiz_id' => $idQuiz,
                'code' => encrypt(date('Y-m-d H:i:s') . auth()->user()->id)
            ]);

            $codeQuiz = $newRecord->code;
            $result_id = $newRecord->id; // ID dari data yang baru saja di-insert
            foreach ($request->answer as $question_id => $answers_id) {
                $id = $question_id;
                $answer_id = decrypt($answers_id);
                $totalQuestion = Question::with(['answer'])->find($id);
                $correct = 0;
                $score = 0;
                if ($totalQuestion->answer->find($answer_id)->correct === 1) {
                    $totalScore += $totalQuestion->score;
                    $score = $totalQuestion->score;
                    $correct = 1;
                };
                Answer_user::create([
                    'result_id' => $result_id,
                    'question_id' => $question_id,
                    'user_id' => auth()->user()->id,
                    'answer_id' => $answer_id,
                    'correct' => $correct,
                    'score' =>  $score
                ]);
            };

            $quizQuestions = Quiz::find($idQuiz)->question;
            foreach ($quizQuestions as $question) {
                if (!isset($request->answer[$question->id])) {
                    // User did not answer this question
                    Answer_user::create([
                        'result_id' => $result_id,
                        'question_id' => $question->id,
                        'user_id' => auth()->user()->id,
                        'answer_id' => null, // Use null to indicate no answer
                        'correct' => 0, // Not correct because it's unanswered
                        'score' => 0, // No score for unanswered questions
                    ]);
                };
            };

            $updateScore = Result::find($result_id);
            $updateScore->score = $totalScore;
            $updateScore->save();
            DB::commit();
            return redirect('/nilai/details/' . $codeQuiz);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/quiz/start/' . decrypt($request->bubblesmart))->with('messages', 'Kerjakan minimal satu soal!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        return view('users.quiz.start', [
            'app' => Application::all(),
            'title' => 'Quiz',
            'titleQuiz' => $quiz->title,
            'codeQuiz' => $quiz->id,
            'bubblesmart' => $quiz->slug,
            'quizzes' => $quiz->question()->with(['answer', 'quiz'])->get()
        ]);
    }
}
