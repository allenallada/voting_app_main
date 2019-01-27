<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $guarded = [];

    public function votes()
    {
    	return $this->hasMany(Vote::class);
    }
}
