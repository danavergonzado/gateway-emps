<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\TimeLog;
use App\User;
use Auth;
use Session;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sessionid(){
        return Session::getID();
    }

    protected function userid(){
        return Auth::user()->id;
    }

    protected function employeeid(){
        return Auth::user()->employee_id;
    }
    
    // stuff to do after user logs in
    protected function authenticated()
    {
        DB::beginTransaction();
        try{
            // 1. Save User last_logged_in
        $last_logged_in = User::where('id', $this->userid())->update(['last_logged_in'=>date('Y-m-d H:i:s')]);
          
            // 2. Save user log
            $dateToday = date('Y-m-d'); 
            $log = TimeLog::where(['user_id'=> $this->userid(),'date' =>  $dateToday])->get();
            if(count($log) == 0){
                $log = TimeLog::create([
                    'user_id'       => $this->userid(),
                    'session_id'    => $this->sessionid(),
                    'employee_id'   => $this->employeeid(), 
                    'date'          => $dateToday
                ]);
            }

            if($log && $last_logged_in){
                DB::commit();
                return redirect()->back();
            }
        }
        catch(Exception $ex){
            DB::rollback();
            return redirect('/login');
        }
    }

}