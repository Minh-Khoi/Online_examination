<?php

namespace App\Http\Controllers;

use App\QuizUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * If the user is an Admin (is_admin == 1) the site will go to the view "admin.admin"
     * (file admin/admin.blade.php). Else, the site will go to the view "user.user" (file user/user.blade.php)
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // find the user who are logging in
        $current_user = Auth::user();
        $current_user_mark = 0;
        return view('admin.admin')->with("current_user", $current_user);
    }

    public function getFormData(Request $request)
    {
        return dd($request->all());
    }

    /**
     * This function will escape the vue 's blade file (admin.admin) and go to the the blade file having the
     * examination form (on_exam.on_exam)
     */
    public function go_to_exam(Request $request)
    {
        $json_rendering = [];
    }
}
