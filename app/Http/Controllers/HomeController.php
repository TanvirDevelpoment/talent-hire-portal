<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $quiz_list = json_encode(Quiz::where('status',1)->inRandomOrder()->limit(10)->get());
        // dd($users);
        if (Cache::has('quiz_list')) {
            $quizzes = Cache::get('quiz_list');
            Cache::flush();
        }else{            
            Cache::put('quiz_list', $quiz_list, now()->addMinutes(3));
            $quizzes = Cache::get('quiz_list');
        }
        $quiz_test_by_examinee = QuizTest::where('user_id', auth()->user()->id)->first();
       
        return view('home',compact('quizzes','quiz_test_by_examinee'));// return "Welcome to General User";
        
    }
    public function showCvLink(Request $request, $file){
        return response()->file( storage_path('app/public/user_cv_link/'.$file));
    }

    
}
