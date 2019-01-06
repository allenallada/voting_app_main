<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Voter;
use App\Vote;

class VotersController extends Controller
{
    public function index()
    {
    	$voters = Voter::all();
    	return view('voter.home', compact('voters'));
    }

    public function store()
    {
    	$validator = Validator::make(request()->all(), [
            'qr_code' => 'required|string|max:255|unique:voters',
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

        // dd($qrCode, $qrId, $qrStudentId,$name);

        Voter::create([
    		'qr_code' => $qrCode,
    		'name' => $name,
    		'qr_code_id' => $qrId,
    		'qr_code_student_id' => $qrStudentId,
    		'qr_code' => $qrCode,
    	]);

    	return [
    		'result' => [
    			'message' => 'Registered successfuly!'
    		]
    	];
    }

    public function login()
    {
    	$validator = Validator::make(request()->all(), [
            'qr_code' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return [
            	'error' => [
            		'message' => 'invalid parameters'
            	]
            ];
        }

    	$voter = Voter::where('qr_code', request('qr_code'))->first();
    	if($voter === null) {
    		return [
            	'error' => [
            		'message' => 'no voter record found'
            	]
            ];
    	}
    	// dd($voter);
    	return [
    		'success' => [
    			'message' => 'successfully logged in!',
    			'has_voted' => $voter->has_voted,
    			'id' => $voter->id
    		]
    	];
    }

    public function vote()
    {
    	$validator = Validator::make(request()->all(), [
            'voter_id' => 'required|integer',
            'p_id' => 'required|integer|',
            'vp_id' => 'required|integer|',
            'sec_id' => 'required|integer|'
        ]);

        if ($validator->fails()) {
            return [
            	'error' => [
            		'message' => 'invalid parameters'
            	]
            ];
        }

    	$voter = Voter::findOrFail(request('voter_id'));

    	// dd($voter);
    	// dd(request()->all());

    	$candidateList = [
    		'p_id' => 'President',
    		'vp_id' => 'Vice President',
    		'sec_id' => 'Secretary'
    	];

    	foreach ($candidateList as $key => $value) {
    		Vote::create([
	    		'voter_id' => request('voter_id'),
	    		'candidate_id' => request($key),
	    		'position' => $value
	    	]);
    	}

    	$voter->has_voted = true;
    	$voter->save();

    	return [
    		'success' => [
    			'message' => 'vote submitted'
    		]
    	];
    	// $voters = Voter::all();
    	// return view('voter.home', compact('voters'));
    }
}
