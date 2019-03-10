<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Voter;
use App\Vote;
use App\Candidate;
use App\Partylist;

class VotersController extends Controller
{
    public function index()
    {
        $voters = Voter::all();
        return view('voter.home', compact('voters'));
    }

    public function deleteSelected()
    {
        $aTodelete = request()->all();
        foreach ($aTodelete as $key => $value) {
            if($key !== '_method') {
                $voter = Voter::findOrFail($value);
                $this->delete($voter);
            }
        }
        return back();
    }

    public function delete(Voter $voter)
    {
        $votes = $voter->votes;
        foreach ($votes as $vote) {
            $vote->delete();
        }
        $voter->delete();
        return back();
    }

    public function reset(Voter $voter)
    {
        $votes = $voter->votes;
        foreach ($votes as $vote) {
            $vote->delete();
        }
        $voter->has_voted = false;
        $voter->mac_address = 'N/A';
        $voter->save();
        return back();
    }

    public function deleteAll()
    {
        Voter::truncate();
        Vote::truncate();
        return back();
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'qr_code' => ['required', 'string', 'max:255', 'regex:/^(\D+[0-9]{2}-[0-9]{6}[A-Z]{2}\s+[0-9]{4}|TUPC-[0-9]{2}-[0-9]{4}.+|\D+[0-9]{4})$/m'],
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

        Voter::create([
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
            'mac_address' =>  'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return [
                'error' => [
                        'message' => 'invalid parameters'
                ]
            ];
        }

        $voterscount = Voter::where('mac_address', request('mac_address'))->count();


        if($voterscount >= 3) {
            return [
                'error' => [
                    'message' => 'Max usage of this phone is already reached'
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

        $voterscount = Voter::where('mac_address', request('mac_address'))->count();


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
        $voter = Voter::findOrFail(request('voter_id'));

        if($voter->has_voted !== 0){
                return [
                        'error' => [
                                 'message' => 'already voted!'
                         ]
                 ];
        }

        $candidateList = [
                'p_id' => 'President',
                'vp_id' => 'Vice President',
                'sec_id' => 'Secretary'
        ];

        $summary = [];

        foreach ($candidateList as $key => $value) {
                if($value !== -1){
                    Vote::create([
                        'voter_id' => request('voter_id'),
                        'candidate_id' => request($key),
                        'position' => $value
                    ]);
                    $can = Candidate::find(request($key));
                    $can['partylist'] = $can->partylist_id === 0 ? 'Independent' : Partylist::find($can->partylist_id)->first()->name;
                    array_push($summary, $can);
                }
        }
        if(request('sen_ids') !== null){
            $senArray = explode(",", request('sen_ids'));
                foreach ($senArray as $key => $value) {
                    Vote::create([
                            'voter_id' => request('voter_id'),
                            'candidate_id' => $value,
                            'position' => 'Senator'
                    ]);

                    $can = Candidate::find($value);
                    $can['partylist'] = $can->partylist_id === 0 ? 'Independent' : Partylist::find($can->partylist_id)->first()->name;
                    array_push($summary, $can);
            }
        }

        if(request('gov_ids') !== null){
            $govArray = explode(",", request('gov_ids'));
            foreach ($govArray as $key => $value) {
                    Vote::create([
                            'voter_id' => request('voter_id'),
                            'candidate_id' => $value,
                            'position' => 'Governor'
                    ]);

                    $can = Candidate::find($value);
                    $can['partylist'] = $can->partylist_id === 0 ? 'Independent' : Partylist::find($can->partylist_id)->first()->name;
                    array_push($summary, $can);
            }
        }

        $voter->has_voted = true;
        $voter->mac_address = request('mac_address');
        $voter->save();

        return [
                'success' => [
                        'message' => 'vote submitted'
                ],
                'summary' => $summary
        ];
    }
}

//<a href="/" class="btn btn-primary">Cancel</a>