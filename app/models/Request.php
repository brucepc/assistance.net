
<?php

namespace Models;

class Request extends \Eloquent
{
	protected $guarded = array('id', 'created_at');

	public function creator()
	{
		return $this->belongsTo('Models\User', 'creator_user_id');
	}
	public function provider()
	{
		return $this->belongsTo('Models\User', 'provider_user_id');
	}
}