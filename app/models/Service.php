<?php

namespace Models;

class Service extends \Eloquent
{
	protected $guarded = array('id', 'created_at');

	public function folder() { return $this->belongsTo('MessageFolder'); }

	public function creator()
	{
		return $this->belongsTo('User', 'creator_user_id');
	}
	public function receiver()
	{
		return $this->belongsTo('User', 'receiver_user_id');
	}
}