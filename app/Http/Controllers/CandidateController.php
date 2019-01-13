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
            'photo' => 'required|image'
        ]);

        $image = request()->file('photo');
        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('/images');
        $image->move($path, $input['imagename']);
        // dd(request()->file('photo'));
        Candidate::create([
    		'student_id' => request('student_id'),
    		'name' => request('name'),
    		'partylist_id' => request('partylist_id'),
    		'section' => request('section'),
    		'position' => request('position'),
            'image_name' => $input['imagename']
    	]);

		return back();
	}

	public function delete(Candidate $candidate)
	{
		$candidate->delete();
		return back();
	}

    public function getCandidates()
    {
        $presidents = Candidate::where('position', 'President')->get();

        $presidentJson = [];

        foreach ($presidents as $key => $president) {
            array_push($presidentJson, [
                'id' => $president->id,
                'name' => $president->name,
                'position' => $president->position,
                'partylist' => $president->partylist_id === 0 ? 'Independent' : Partylist::find($president->partylist_id)->first()->name,
                'section' => $president->section
            ]);
            # code...
        }


        $vpresidents = Candidate::where('position', 'Vice President')->get();

        $vpresidentJson = [];

        foreach ($vpresidents as $key => $vpresident) {
            array_push($vpresidentJson, [
                'id' => $vpresident->id,
                'name' => $vpresident->name,
                'position' => $vpresident->position,
                'partylist' => $vpresident->partylist_id === 0 ? 'Independent' : Partylist::find($vpresident->partylist_id)->first()->name,
                'section' => $vpresident->section
            ]);
            # code...
        }
        $secretaries = Candidate::where('position', 'Secretary')->get();
        $secretariesJson = [];

        foreach ($secretaries as $key => $secretary) {
            array_push($secretariesJson, [
                'id' => $secretary->id,
                'name' => $secretary->name,
                'position' => $secretary->position,
                'partylist' => $secretary->partylist_id === 0 ? 'Independent' : Partylist::find($secretary->partylist_id)->first()->name,
                'section' => $secretary->section
            ]);
            # code...
        }

        return [
            'candidates' => [
                'presidents' => $presidentJson,
                'vice_presidents' => $vpresidentJson,
                'secretaries' => $secretariesJson
            ] 
        ];
    }
}
