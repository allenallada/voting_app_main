<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partylist extends Model
{
    protected $guarded = [];

    public function members()
    {
    	return $this->hasMany(Candidate::class);
    }

}
