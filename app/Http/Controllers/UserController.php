<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // if($user->quizTest){
        //     $start = Carbon::parse(date('Y-m-d').' '.$user->quizTest->time_consumed);
        //     $end = Carbon::parse(date('Y-m-d').' 0:2:0');
           
        //     $time_consumed = $start->diff($end)->format('%H:%I:%S');
        // }else{
        //     $time_consumed = '';
        // }
        // dd($user->quizTest);
        $title = "Show Examinee Details";
        return view('admin.users.show_user',compact('title','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // dd($user);
        $title = "Edit User";
        return view('admin.users.edit_user',compact('title','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
    //    dd($request->all());
        if($request->cv_link){
            if (File::exists(storage_path('app/public/user_cv_link/'.$user->cv_link || $user->cv_link != null))) { // unlink or remove previous image from folder
                unlink (storage_path('app/public/user_cv_link/'.$user->cv_link));
                // dd($user->cv_link);
            }            
            $file_name = $request->cv_link->getClientOriginalName();
 
            $file_path =  $request->cv_link->store('public/user_cv_link');
            $only_name_explode = explode('/',$file_path);
            $only_file_name = $only_name_explode[2];
        }else{
            $only_file_name = $user->cv_link;
        }
        // dd($request->all());
        $formFeilds = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:15'],
            'cv_link' => 'mimes:txt,pdf|max:2048',
            'status' => 'required'
        ]);
        $formFeilds['cv_link'] = $only_file_name;
        // dd($formFeilds);
        $user->update($formFeilds);
        return back()->with('success','User Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success','User Deleted Successfully.');
    }
}
