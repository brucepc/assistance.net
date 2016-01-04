<?php

namespace Models;

class Profile extends User
{
	protected $primaryKey = 'user_id';
	public $timestamps = false;

	public function user() { return $this->belongsTo('Models\User'); }
	public function experiences() { return $this->hasMany('Models\Experience', 'user_id'); }
}
