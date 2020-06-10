<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index()
    {
        if($user = Auth::user()){
           redirect('/home');
        }
        return view('auth.register');
    } 
    

    public function register(Request $request)
    {   
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'position' => ['required', 'string', 'max:30'],
            'employee_id' => ['required', 'string', 'min:4'],
            'company_id' => ['required'],
            'branch_id' => ['required']
        ]);
        
       $success =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'branch_id' => $data['branch_id'], 
            'employee_id' =>$data['employee_id'],
            'position' => $data['position'],
            'company_id' => $data['company_id']
        ]);
        return redirect('/user/register')->withSuccess(['Success: New user added']);
        //return redirect('/user/register');
    }
    
    public function update_password(Request $request)
    {
        // if empty ang old password
        if( empty($request->get('old_password'))){
            return "Please enter your password. ";
        }

        // if old password entry does not match with password logged in
        if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
            return  "Your current password does not matches with the password you provided. Please try again.";
        }

        // if new password is the same with old one
        if(strcmp($request->get('old_password'), $request->get('new_password')) == 0){
            return "New Password cannot be same as your current password.";
        }

        // if empty ang new password
        if( empty($request->get('new_password'))){
            return "Please enter a new password. ";
        }

        // if empty ang password corfirmation
        if( empty($request->get('password_confirmation'))){
            return "Please confirm your new password. ";
        }

        // if new password and password confirmation wla nag match
        if(strcmp($request->get('new_password'), $request->get('password_confirmation')) != 0){
            return "Password mismatch";
        }

        if(strlen($request->get('new_password'))<6){
            return "Password should be atleast 6 characters";
        }

        $user = Auth::user();
        $user->password = Hash::make($request->get('new_password'));
        $success = $user->save();
        return $success;


        
    }

    
}
