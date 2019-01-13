<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
	protected $guarded = [];

    public function partylist()
    {
    	return $this->belongsTo(Partylist::class);
    }

    public function vote()
    {
    	return $this->hasMany(Vote::class);
    }
    //
}
