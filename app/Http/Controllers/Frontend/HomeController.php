<?php

namespace App\Http\Controllers\Frontend;

use App\Models;
use App\RoleUser;
use App\Wallpapers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct(){
        // $this->middleware(['auth', 'user']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()) {
            return redirect()->route('login');
        }

        $admin = RoleUser::where('role_id', 1)->first();
        $adminid = $admin->user_id;
        $userid = auth()->id();

        $models = Models::all();
        $wallpapers = Wallpapers::whereIn('created_by', [$userid, $adminid])->get();

        return view('frontend.home', compact('models', 'wallpapers'));
    }
}
