<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use App\Candidate;

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
    	$admins = Admin::all();
    	$PCandidates = Candidate::withCount('vote')->where('position', 'President')->orderBy('vote_count', 'desc')->get();
    	$VCandidates = Candidate::withCount('vote')->where('position', 'Vice President')->orderBy('vote_count', 'desc')->get();
    	$SCandidates = Candidate::withCount('vote')->where('position', 'Secretary')->orderBy('vote_count', 'desc')->get();
    	return view('admin.home', compact('admins', 'PCandidates', 'VCandidates', 'SCandidates'));
    }

    public function logout()
    {
    	session()->flush();
    	session()->flash('success', 'Logged out Successfully');
    	return redirect('/');
    }

    public function delete(Admin $admin)
    {
    	if(!Hash::check(request('password'), $admin->password)) {
    		session()->flash('error', 'Incorrent Password!'); 
    		return back();
		}

    	$admin->delete();

    	session()->flash('success', 'Admin Deleted!'); 

        return back();
    }

    public function update(Admin $admin)
    {
    	if(!Hash::check(request('password'), $admin->password)) {
    		session()->flash('error', 'Incorrent Password!'); 
    		return back();
		}

    	request()->validate([
            'student_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6'
        ]);

        if(request('new_password') !== null){
        	request()->validate([
	            'new_password' => 'required|string|min:6|confirmed',
	        ]);
        }

        $admin->student_id = request('student_id');
        $admin->name = request('name');
        $admin->username = request('username');

        if(request('new_password') !== null){
        	$admin->password = request('new_password');
        }

        $admin->save();

        session(['user' => $admin]);

        session()->flash('success', 'Information Updated!'); 

        return back();

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
