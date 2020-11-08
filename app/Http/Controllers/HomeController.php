<?php

namespace App\Http\Controllers;

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
        $current_user = Auth::user();
        if ($current_user->is_admin == 1) {
            return view('admin.admin')->with("current_user", $current_user);
        }
        return view('user.user')->with('current_user', $current_user);
    }

    public function getFormData(Request $request)
    {
        return dd($request->all());
    }
}
