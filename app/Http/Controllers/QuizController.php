<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\QuizTest;
// use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Dashboard";
        $quizzes = Quiz::get();
        return view('admin.quizzes.index',compact('title','quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Quiz";
        return view('admin.quizzes.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formFeilds = $request->validate([
            'question' => 'required',
            'options_type' => 'required',
            'correct_option' => 'required',
            'mark' => '',
            'status' => 'required',
            
        ]);
        $json_data = array(
            '1' => $request->option_1,
            '2' => $request->option_2,
            '3' => $request->option_3,
            '4' => $request->option_4,
        );
        
        $formFeilds['options'] = json_encode($json_data);
        $formFeilds['user_id'] = auth()->user()->id;
        // dd(json_encode($json_data));
        Quiz::create($formFeilds);
        return back()->with('success','Quiz Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        $title = "Quiz Edit";
        $json_data = json_decode($quiz->options);
        foreach ($json_data as $key => $value) {
           $data[] =  $json_data->$key;
        }       
        return view('admin.quizzes.edit',compact('title','quiz','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        $formFeilds = $request->validate([
            'question' => 'required',
            'options_type' => 'required',
            'correct_option' => 'required',
            'mark' => '',
            'status' => 'required',
            
        ]);
        $json_data = array(
            '1' => $request->option_1,
            '2' => $request->option_2,
            '3' => $request->option_3,
            '4' => $request->option_4,
        );
        
        $formFeilds['options'] = json_encode($json_data);
        $formFeilds['user_id'] = auth()->user()->id;
        // dd(json_encode($json_data));
        $quiz->update($formFeilds);
        return back()->with('success','Quiz Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return back()->with('success','Quizzz Deleted Successfully.');
    }
    public function storeQuizTestData(Request $request){
        $start = Carbon::parse(date('Y-m-d').' '.$request->submition_time);
        $end = Carbon::parse(date('Y-m-d').' 0:3:0');// Default 3 minutes
        
        $time_consumed = $start->diff($end)->format('%H:%I:%S');
        $corect_ans = 0;
        $totla_marks = 0;
        for($i = 0; $i < count($request->quizData); $i++){
            $explodeData = explode(':',$request->quizData[$i]);
            $explodeValue = explode(',',trim($explodeData[1]));
            $quiz_data = Quiz::where('id',$explodeData[0])->first();
            $new_crct_opt_explode = explode(',',$quiz_data->correct_option);
            $result=array_diff($explodeValue,$new_crct_opt_explode);
            if(count($result) == 0 ){
                $corect_ans++;
                $totla_marks += $quiz_data->mark;
            }
            
        }
        if(Auth::check()){           
            $formFeilds['quiz_test_details'] = json_encode($request->quizData);
            $formFeilds['quiz_perform_qty'] = count($request->quizData);
            $formFeilds['quiz_pass_qty'] = $corect_ans;
            $formFeilds['total_marks_aquired'] = $totla_marks;
            $formFeilds['time_consumed'] = $time_consumed;
            $formFeilds['total_questions'] = $request->total_questions;
            $formFeilds['user_id'] = auth()->user()->id;
            // DB::table('quiz_tests')->insert($formFeilds);
            $quiz_test_data = QuizTest::where('user_id', auth()->user()->id)->first();
            if(!$quiz_test_data){
                if(QuizTest::create($formFeilds)){
                    return json_encode($formFeilds);
                }else{
                    return 'Data not inserted successfully';
                }
            }else{
                return json_encode($quiz_test_data);
            }
        }else{
            return 'You are not registered or logged In.';
        }
    }
}
