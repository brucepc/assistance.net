<?php

namespace Models;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface
{
	use UserTrait, RemindableTrait;

	protected $hidden = array('password');
	protected $fillable = array('email');

	public function profile() { return $this->hasOne('Models\Profile'); }
	public function skills() { return $this->hasManyThrough('Models\Skill', 'User', 'id', 'id'); }

	public function messages() { return $this->hasMany('Models\Message', 'receiver_id')->where('receiver_type','=','1'); } //received messages
	public function sentMessages() { return $this->hasMany('Models\Message', 'sender_id')->where('sender_type','=','1'); } //received messages

	public function requests() { return $this->hasMany('Models\Request', 'creator_user_id'); }
	public function requestsProvided() { return $this->hasMany('Models\Request', 'provider_user_id'); }

	public function services() { return $this->hasMany('Models\Service', 'creator_user_id'); }
	public function servicesReceived() { return $this->hasMany('Models\Service', 'receiver_user_id'); }
}
