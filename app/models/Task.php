<?php

namespace Models;

class Task extends \Eloquent
{
	protected $primaryKey = 'task_id';
	public $timestamps = true;

	public function user() { return $this->belongsTo('User'); }
	public function bill() { return $this->hasMany('Bill');}
}
