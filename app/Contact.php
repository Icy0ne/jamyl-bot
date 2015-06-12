<?php

namespace JamylBot;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {
	protected $fillable = ['id', 'name', 'standing', 'type_id'];

}
