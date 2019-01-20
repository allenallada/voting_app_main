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

        if($voter !== null) {
        	return [
            	'error' => [
            		'message' => 'already exists!'
            	]
            ];
        }

        $qrCode = request('qr_code');

        $fragments = explode(' ', $qrCode);
        $result = array_filter($fragments);           

       	$qrId = array_pop($result);
       	$qrStudentId = array_pop($result);
       	$name = implode(' ', $result);

       	$parameters = [
       		'id_no' => $qrId,
       		'student_id' => $qrStudentId,
       		'name' => $name,
       	];

       	$validator = Validator::make($parameters, [
            'id_no' => 'required|digits:4',
            'student_id' => 'required|string|size:11',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
            	'error' => [
            		'message' => 'invalid parameters'
            	]
            ];
        }

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
            'mac_address' => 'required|string|max:255'
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

        $voterscount = Voter::where('mac_address', request('qr_code'))->count();

        if($voterscount >= 3) {
            return [
                'error' => [
                    'message' => 'Max usage of this phone is already reached'
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
            'mac_address' => 'required|string',
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
    	$voter->mac_address = request('mac_address');
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
