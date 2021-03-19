<?php

namespace App\Http\Controllers\Frontend;

use App\Models;
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

        $models = Models::all();
        return view('frontend.home', compact('models'));
    }
}
