<?php

namespace App\Http\Controllers;

use App\Charts\AnswerQuizChart;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Thread;
use App\Models\Application;

class AdminDashboardController extends Controller
{
    public function index(AnswerQuizChart $chart)
    {
        return view('admin.dashboard.index', [
            'app' => Application::all(),
            'title' => 'Dashboard',
            'totalQuiz' => Quiz::count(),
            'totalLakiLaki' => User::where('gender', 'Laki-Laki')->where('is_admin', '!=', 1)->count(),
            'totalPerempuan' => User::where('gender', 'Perempuan')->where('is_admin', '!=', 1)->count(),
            'members' => User::where('is_admin', 0)->latest()->take(4)->select('name', 'image', 'created_at')->get(),
            'totalMember' => User::where('is_admin', false)->count(),
            'answersQuiz' => Result::all()->count(),
            'threads' => Thread::all()->count(),
            'chart' => $chart->build()
        ]);
    }
}
