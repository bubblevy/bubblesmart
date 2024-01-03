<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Answer_user;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Quiz;
use Illuminate\Support\Facades\DB;
use App\Models\Application;

class AdminDataQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dataquiz.index', [
            'app' => Application::all(),
            'title' => 'Data Quiz',
            'allQuiz' => Quiz::latest()->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255|min:100',
        ]);

        $validated['slug'] = encrypt(date('Y-m-d H i s'));
        $validated['status'] = "Nonaktif";


        Quiz::create($validated);
        return redirect('/admin/data-quiz')->with('quizSuccess', 'Quiz berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        return view('admin.dataquiz.show', [
            'app' => Application::all(),
            'title' => 'Soal & Jawaban Quiz',
            'code' =>  $quiz->slug,
            'titleQuiz' => $quiz->title,
            'questions' => $quiz->question()->with(['answer', 'quiz'])->latest()->paginate(10)
        ]);
    }

    public function addquestion(Quiz $quiz)
    {
        $questions = $quiz->question->where('quiz_id', $quiz->id)->first();
        if ($questions) {
            $answerUserCount = Answer_user::where('question_id', $questions->id)->count();
            if ($answerUserCount > 0) {
                return redirect('/admin/data-quiz/q&a/' . $quiz->slug)->with('updateQuestionError', 'Data quiz digunakan users!');
                exit;
            }
        }

        $validated = Request()->validate([
            'question' => 'Required',
            'score' => 'Required|numeric|min:1|max:100',
            'option.1' => 'Required|max:255',
            'option.2' => 'Required|max:255',
            'option.3' => 'Required|max:255',
            'option.4' => 'Required|max:255',
            'correctAnswer' => 'Required|in:1,2,3,4'
        ], [
            'option.1.required' => 'The option 1 field is required.',
            'option.1.max' => 'The option 1 field must not be greater than 255 characters.',
            'option.2.required' => 'The option 2 field is required.',
            'option.2.max' => 'The option 2 field must not be greater than 255 characters.',
            'option.3.required' => 'The option 3 field is required.',
            'option.3.max' => 'The option 3 field must not be greater than 255 characters.',
            'option.4.required' => 'The option 4 field is required.',
            'option.4.max' => 'The option 4 field must not be greater than 255 characters.',
        ]);

        // transaction database
        DB::beginTransaction();
        try {
            // insert questions
            $newRecordQuestion = Question::create([
                'quiz_id' => $quiz->id,
                'question' => $validated['question'],
                'score' => $validated['score']
            ]);

            $question_id = $newRecordQuestion->id; // ambil id question yang baru saja diinsert

            //loop answers
            foreach (Request()->option as $index => $opsi) {
                $correct = 0;
                if ($index == Request()->correctAnswer) {
                    $correct = 1;
                }

                Answer::create([
                    'question_id' => $question_id,
                    'answer' => $opsi,
                    'correct' => $correct
                ]);
            }
            DB::commit();
            return redirect('/admin/data-quiz/q&a/' . $quiz->slug)->with('questionSuccess', 'Soal berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/data-quiz/q&a/' . $quiz->slug)->with('questionFailed', 'Upss..Terjadi kesalahan!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'titleQuiz' => 'required|max:255',
            'descriptionQuiz' => 'required|max:255|min:100',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'titleQuiz.required' => 'The title field is required.',
            'titleQuiz.max' => 'The title field must not be greater than 255 characters.',
            'descriptionQuiz.required' => 'The description field is required.',
            'descriptionQuiz.max' => 'The description field must not be greater than 255 characters.',
        ]);

        $validated['title'] = $validated['titleQuiz'];
        $validated['description'] = $validated['descriptionQuiz'];
        unset($validated['titleQuiz']);
        unset($validated['descriptionQuiz']);

        Quiz::where('slug', $request->codeQuiz)
            ->update($validated);
        return back()->with('updateQuizSuccess', 'Quiz berhasil diupdate!');
    }


    // update question
    public function updatequestion(Request $request)
    {
        $validated = $request->validate([
            'editQuestion' => 'Required',
            'editScore' => 'Required|numeric|min:1|max:100',
            'editOption.1' => 'Required|max:255',
            'editOption.2' => 'Required|max:255',
            'editOption.3' => 'Required|max:255',
            'editOption.4' => 'Required|max:255',
            'editCorrectAnswer' => 'Required|in:1,2,3,4'
        ], [
            'editCorrectAnswer.required' => 'The jawaban benar field is required.',
            'editQuestion.required' => 'The pertanyaan field is required.',
            'editScore.required' => 'The score field is required.',
            'editScore.min' => 'The score field must be at least 1.',
            'editScore.max' => 'The score field must not be greater than 100.',
            'editOption.1.required' => 'The option 1 field is required.',
            'editOption.1.max' => 'The option 1 field must not be greater than 255 characters.',
            'editOption.2.required' => 'The option 2 field is required.',
            'editOption.2.max' => 'The option 2 field must not be greater than 255 characters.',
            'editOption.3.required' => 'The option 3 field is required.',
            'editOption.3.max' => 'The option 3 field must not be greater than 255 characters.',
            'editOption.4.required' => 'The option 4 field is required.',
            'editOption.4.max' => 'The option 4 field must not be greater than 255 characters.',
        ]);

        $validated['question'] = $validated['editQuestion'];
        $validated['score'] = $validated['editScore'];
        unset($validated['editQuestion']);
        unset($validated['editScore']);

        $quizID = Question::find(decrypt($request->codeQuestion))->quiz_id;
        $quiz = Quiz::find($quizID);
        $slugUrl = $quiz->slug;
        $answerUserCount = Answer_user::where('question_id', decrypt($request->codeQuestion))->count();
        if ($answerUserCount > 0) {
            return redirect('/admin/data-quiz/q&a/' . $slugUrl)->with('updateQuestionError', 'Data Soal digunakan users!');
            exit;
        }
        // transaction database
        DB::beginTransaction();
        try {
            $question_id = decrypt($request->codeQuestion);
            // update question
            Question::where('id', $question_id)
                ->update([
                    'question' => $validated['question'],
                    'score' => $validated['score']
                ]);

            // delete answer lama
            Answer::where('question_id', $question_id)->delete();

            //loop answers baru
            foreach ($request->editOption as $index => $opsi) {
                $correct = 0;
                if ($index == $request->editCorrectAnswer) {
                    $correct = 1;
                }

                Answer::create([
                    'question_id' => $question_id,
                    'answer' => $opsi,
                    'correct' => $correct
                ]);
            }
            DB::commit();
            return back()->with('updateQuestionSuccess', 'Soal berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('editQuestionFailed', 'Upss..Terjadi kesalahan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {

        $questions = Question::with(['answer_user'])->where('quiz_id', $quiz->id)->get();
        $deleteQuizError = false;
        foreach ($questions as $question) {
            $answerUserCount = Answer_user::where('question_id', $question->id)->count();
            if ($answerUserCount === 0) {
                Answer::where('question_id', $question->id)->delete();
            } else {
                $deleteQuizError = true;
            }
        }
        if ($deleteQuizError) {
            return back()->with('deleteQuizError', 'Data quiz digunakan users!');
            exit;
        }
        Question::where('quiz_id', $quiz->id)->delete();
        Quiz::destroy($quiz->id);
        return back()->with('deleteQuizSuccess', 'Quiz berhasil dihapus!');
    }

    public function destroyquestion(Question $question)
    {
        $answerUserCount = Answer_user::where('question_id', $question->id)->count();
        if ($answerUserCount === 0) {
            Answer::where('question_id', $question->id)->delete();
        } else {
            return redirect('/admin/data-quiz/q&a/' . $question->quiz->slug)->with('deleteQuestionError', 'Data soal digunakan users!');
            exit;
        }
        Question::destroy($question->id);
        return back()->with('deleteQuestion', 'Soal berhasil dihapus!');
    }

    // ajax edit question
    public function getanswer(Request $request)
    {
        $id = decrypt($request->id);
        $data = Answer::where('question_id', $id)->get();
        return $data;
    }

    public function search()
    {
        if (request('q') === null) {
            return redirect('/admin/data-quiz');
            exit;
        }
        return view('admin.dataquiz.search', [
            'app' => Application::all(),
            'title' => 'Data Quiz',
            'allQuiz' => Quiz::latest()->searching(request('q'))->paginate(10)
        ]);
    }
    public function searchquestion(Quiz $quiz)
    {
        if (request('q') === null) {
            return redirect('/admin/data-quiz/q&a/' . $quiz->slug);
            exit;
        }

        return view('admin.dataquiz.searchquestion', [
            'app' => Application::all(),
            'title' => 'Soal & Jawaban Quiz',
            'code' =>  $quiz->slug,
            'titleQuiz' => $quiz->title,
            'questions' => $quiz->question()->with(['answer', 'quiz'])->latest()->searching(request('q'))->paginate(10)
        ]);
    }
}
