<?php

namespace App\Http\Controllers;
use App\Partylist;
use App\Candidate;

use Illuminate\Http\Request;

class PartylistController extends Controller
{
    public function store()
	{
		request()->validate([
            'name' => 'required|string|max:255',
        ]);

        Partylist::create([
    		'name' => request('name'),
    	]);

		return back();
	}

	public function delete(Partylist $partylist)
	{
		$members = $partylist->members;
		foreach ($members as $member) {
			$member->partylist_id = 0;
			$member->save();
			# code...
		}
		$partylist->delete();
		return back();
	}

	public function deleteAll()
	{
		$candidates = Candidate::all();
		foreach ($candidates as $key => $candidate) {
			$candidate->update(['partylist_id' => 0]);
		}
		Partylist::truncate();
		return back();
	}
}
