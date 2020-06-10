<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TimeLog;
use App\Task;
use Auth;
use DB;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $tasks = Task::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->simplePaginate(5);
        return view('task.index')->with('tasks', $tasks);
    }

    public function store(Request $request){

        DB::beginTransaction();
        try {
            $action = (isset($request->action)) ? $request->action : "";
            switch($action){
                case 'edit':
                    $success = Task::where('id', $request->current_row)->update([
                        'name' => $request->task
                    ]);
                    
                    break;

                default: 
                    $success =  Task::create([
                        'name' => $request->task,
                        'category' => 'general',
                        'user_id' => Auth::user()->id
                    ]); 
                    break;
            }

            if($success) DB::commit();
            return true;
            
        } catch (Throwable $ex) {

           DB::rollback();
           return $ex;
        }
       
    }
}
