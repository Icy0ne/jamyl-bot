<?php


namespace JamylBot;

use Illuminate\Database\Eloquent\Model;

class TeamSpeakGroup extends Model {
	protected $fillable = [ 
			'sgid', 'name' 
	];
    public function groups()
    {
        return $this->belongsToMany('JamylBot\Group');
    }
}
