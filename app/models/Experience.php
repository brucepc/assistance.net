<?php

namespace Models;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Experience extends \Eloquent
{
	use SoftDeletingTrait;

	protected $fillable = array('name', 'link', 'start_date', 'end_date', 'description');
	protected $table = 'profile_experiences';

	public function profile() { return $this->belongsTo('Models\Profile', 'user_id'); }

	public function getStartDateAttribute()
	{
		return strtotime($this->attributes['start_date']);
	}
	public function setStartDateAttribute($Date)
	{
		$this->attributes['start_date'] = date('c', $Date);
	}

	public function getEndDateAttribute()
	{
		return strtotime($this->attributes['end_date']);
	}
	public function setEndDateAttribute($Date)
	{
		$this->attributes['end_date'] = date('c', $Date);
	}
}