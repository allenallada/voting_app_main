<?php

namespace App\Http\Controllers;
use App\Partylist;

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
		$partylist->delete();
		return back();
	}
}
