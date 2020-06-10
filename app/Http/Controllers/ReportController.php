<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\TimeLog;
use Auth;
class ReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->showUsers();
    }

    public function showUsers()
    {
        $users = User::orderBy('id', 'ASC')->paginate(20);
        return view('report.hr')->with('users', $users);
    }

    public function showTimeLogs(Request $request)
    {
        $logs = TimeLog::where('user_id', Auth::user()->id)
            ->orderBy('date', 'desc')
            ->simplePaginate(20);
        return view('report.timelogs')->with('logs', $logs);
    }
}
