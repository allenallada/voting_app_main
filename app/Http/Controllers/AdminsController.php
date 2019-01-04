<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
    		'password' => request('password')
    	]);

    	session()->flash('success', 'You have Successfully Registered'); 

    	return redirect('/');
    }
}
