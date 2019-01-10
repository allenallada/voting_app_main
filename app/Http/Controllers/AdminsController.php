<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Admin;

class AdminsController extends Controller
{
    //
    public function register()
    {
    	return view('admin.register');
    }

    public function create()
    {
		request()->validate([
            'student_id' => 'required|string|max:255|unique:admins',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'position' => 'required|string|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
        ]);

    	Admin::create([
    		'student_id' => request('student_id'),
    		'name' => request('name'),
    		'username' => request('username'),
    		'position' => request('position'),
    		'password' => bcrypt(request('password'))
    	]);

    	session()->flash('success', 'You have Successfully Registered'); 

    	return redirect('/');
    }

    public function login()
    {
    	$user = Admin::where('username', request('username'))->first();
    	if($user === null) {
    		session()->flash('error', 'No user found'); 
    		return back();
    	}

    	if(!Hash::check(request('password'), $user->password)) {
    		session()->flash('error', 'Incorrent Password!'); 
    		return back();
		}
		session(['user' => $user]);

		return redirect('/admin');
    }

    public function home()
    {
    	return view('admin.home');
    }

    public function logout()
    {
    	session()->flush();
    	session()->flash('success', 'Logged out Successfully');
    	return redirect('/');
    }

    public function apiLogin()
    {
    	$validator = Validator::make(request()->all(), [
            'qr_code' => 'required',
        ]);

    	if ($validator->fails()) {
            return [
            	'error' => [
            		'message' => 'invalid parameters'
            	]
            ];
        }

        $qrCode = request('qr_code');

        $fragments = explode(' ', $qrCode);
        $result = array_filter($fragments);           

       	$qrId = array_pop($result);
       	$qrStudentId = array_pop($result);
       	$name = implode(' ', $result);
    	$user = Admin::where('student_id', $qrStudentId)->first();
    	dd($user);
    	if($user === null){
    		return [
            	'error' => [
            		'message' => 'no user found!'
            	]
            ];
    	}

    	return [
	    		'success' => [
	    			'message' => 'successfully logged in!'
	    		]
	    	];
    }
}
