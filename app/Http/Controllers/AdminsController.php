<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use App\Setting;
use App\Candidate;
use App\Poll;
use App\Voter;
use PDF;
use DateTime;

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
            'name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'username' => 'required|string|max:255|unique:admins',
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
    	$polls = Poll::all();
        $status = [];

        foreach ($polls as $key => $value) {
            $startDate = new DateTime($value->start);
            $endDate = new DateTime($value->end);
            $current = new DateTime();
            if($current < $startDate) {
                $status[] = 'Not Started';
            } else if ($current > $endDate) {
                $status[] = 'Finished';
            } else {
                $status[] = 'On Going';
            }
            # code...
        }

        $pollingStatus = false;
        foreach ($polls as $key => $poll) {
            $current = new DateTime(now());
            $st_dt = new DateTime($poll->start);
            $end_dt = new DateTime($poll->end);
            if($current > $st_dt && $current < $end_dt){
                $pollingStatus = true;
            }
        }

    	$PCandidates = Candidate::withCount('vote')->where('position', 'President')->orderBy('vote_count', 'desc')->get();
    	$VCandidates = Candidate::withCount('vote')->where('position', 'Vice President')->orderBy('vote_count', 'desc')->get();
        $SCandidates = Candidate::withCount('vote')->where('position', 'Secretary')->orderBy('vote_count', 'desc')->get();
        $SenCandidates = Candidate::withCount('vote')->where('position', 'Senator')->orderBy('vote_count', 'desc')->get();
        $GCandidates = Candidate::withCount('vote')->where('position', 'Governor')->orderBy('vote_count', 'desc')->get();
    	$setting = Setting::all()->first();
        if ($setting === null){
            Setting::create([
                'max_sen' => 5,
                'max_gov' => 5
            ]);
            $setting = Setting::all()->first();
        }

    	return view('admin.home', compact(
            'admins',
            'PCandidates',
            'VCandidates',
            'SCandidates',
            'SenCandidates',
            'GCandidates',
            'setting',
            'polls',
            'status',
            'pollingStatus'
        ));
    }

    public function exportResult()
    {
        $aCandidates = [
            'President'      =>  Candidate::withCount('vote')->where('position', 'President')->orderBy('vote_count', 'desc')->get(),
            'Vice President' =>  Candidate::withCount('vote')->where('position', 'President')->orderBy('vote_count', 'desc')->get(),
            'Secretary'      =>  Candidate::withCount('vote')->where('position', 'President')->orderBy('vote_count', 'desc')->get(),
            'Senator'        =>  Candidate::withCount('vote')->where('position', 'President')->orderBy('vote_count', 'desc')->get(),
            'Governor'       =>  Candidate::withCount('vote')->where('position', 'President')->orderBy('vote_count', 'desc')->get()
        ];

        $pdf = PDF::loadView('admin.export', compact('aCandidates'));
        return $pdf->download('summary.pdf');
    }

    public function exportVoters()
    {
        $voters = Voter::all();
        $pdf = PDF::loadView('admin.votersexport', compact('voters'));
        return $pdf->download('voters.pdf');
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
            'name' => 'required|string|max:255|alpha',
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
        	$admin->password = bcrypt(request('new_password'));
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
        $qrStudentId = '';
        $fragments = explode(' ', $qrCode);
        $result = array_filter($fragments);   

        foreach ($result as $value) {
            if(preg_match('/^^[0-9]{2}-[0-9]{6}[A-Z]{2}$/m', $value) === 1 || preg_match('/^^TUPC-[0-9]{2}-[0-9]{4}$/m', $value) === 1){
                $qrStudentId = $value;
            }
        }

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

    public function storepoll(){
        request()->validate([
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $st_dt = new DateTime(request('start_time'));
        $end_dt = new DateTime(request('end_time'));

        if($st_dt > $end_dt){
            session()->flash('error', 'Start time must be earlier than end time'); 
            return;
        }

        Poll::create([
            'start' => request('start_time'),
            'end' => request('end_time')
        ]);

        return back();
    }

    public function deletepoll(Poll $poll){
        $poll->delete();
        return back();
    }

    public function setMax(){

        if(Setting::all()->count() === 0){
            Setting::create([
                'max_sen' => request('max_sen'),
                'max_gov' => request('max_gov')
            ]);
        } else {
            $setting = Setting::all()->first();
            $setting->max_sen = request('max_sen');
            $setting->max_gov = request('max_gov');
            $setting->save();
        }

        return back();
    }



}
