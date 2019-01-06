<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidate;
use App\Partylist;

class CandidateController extends Controller
{
    //	
    public function index()
	{
		$candidates = Candidate::all();
		$partylists = Partylist::all();
		return view('candidate.home', compact('candidates', 'partylists'));
	}

    public function store()
	{
		request()->validate([
            'student_id' => 'required|string|max:255|unique:candidates',
            'name' => 'required|string|max:255',
            'partylist_id' => 'required|integer|min:0',
            'section' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        Candidate::create([
    		'student_id' => request('student_id'),
    		'name' => request('name'),
    		'partylist_id' => request('partylist_id'),
    		'section' => request('section'),
    		'position' => request('position')
    	]);

		return back();
	}

	public function delete(Candidate $candidate)
	{
		$candidate->delete();
		return back();
	}
}
