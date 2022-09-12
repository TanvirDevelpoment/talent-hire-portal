<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $title = "Dashboard";
        $users = User::where('role_as',0)->get();
        return view('admin.admin_dashboard',compact('title','users'));
      }
}
