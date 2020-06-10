<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeLog;
use App\User;
use App\Task;
use Auth;

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
        $log = TimeLog::where([
            'user_id'   =>  Auth::user()->id,
            'date'  =>  date('Y-m-d')
            ])->get();

        return view('home')->with(['log'=>$log]);
    }

    public function hr()
    {
        
        $logs = TimeLog::orderBy('id', 'DESC')->paginate(20);
        return view('hr.index')->with(['logs'=>$logs]);
    }
}
