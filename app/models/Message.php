<?php

namespace Models;

class MessageFolder extends \Eloquent
{
	protected $table = 'message_folders';
}

class Message extends \Eloquent
{
	protected $guarded = array('id', 'created_at');

	public function folder() { return $this->belongsTo('MessageFolder'); }
}