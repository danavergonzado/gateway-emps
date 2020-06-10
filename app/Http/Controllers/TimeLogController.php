<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeLog;
use App\Task;
use Auth;
use Session;

class TimeLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function timein(Request $request)
    {
        $session_id = Session::getID();

        if(!empty($session_id))
        {
             $userlog = TimeLog::where(['date' => date('Y-m-d'), 'user_id' => Auth::user()->id ])->get();

              if(count($userlog) < 0 ) 
              {
                    return "No logs found";
              } 
              else 
              {
                    if(strcmp($request->comp_num, $userlog[0]->employee_id) != 0)
                    {
                        return "Invalid or  mismatched ID number.";
                    }

                    $date = date('Y-m-d H:i:s');
                    
                    if(is_null($userlog[0]->timein))
                    {
                        TimeLog::where([
                            'user_id'=> Auth::user()->id,
                            'date' => date('Y-m-d')
                            ])->update(['timein' => $date]);
                            
                        return true;
                    }
                    else
                    {
                        $tasks = Task::where('user_id', Auth::user()->id)
                                ->whereDate('created_at', '=', date('Y-m-d'))
                                ->get();
                                
                        if(count($tasks) == 0)
                        {
                            return "You have 0 task for today. Please add before signing out.";
                        }
                        
                        else
                        {
                            TimeLog::where([
                                'user_id'=> Auth::user()->id,
                                'date' => date('Y-m-d')
                                ])->update(['timeout' => $date]);
                                
                            return true;
                        }
                        
                    }
              }    
        }
    }


    public function log(Request $request)
    {
        if($request->all()){
            $date = explode('-',$request->range);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime($date[1]));

            $result = TimeLog::whereBetween('date', [$from, $to])->get();
            $range  = $request->range;  
            
            return view('log.index')->with(['logs'=>$result, 'range'=>$range]);
        }else{
            return view('log.index');
        }
        
       
    }

}
