<?php

namespace Models;

class SkillTag extends \Eloquent 
{
	protected $table = 'skill_tags';
	public function skill() { return $this->belongsTo('Skill'); }
}

class Skill extends \Eloquent
{
	public function tags() { return $this->hasMany('SkillTag'); }
}