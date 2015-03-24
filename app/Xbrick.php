<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Xbrick extends Model {

	protected $table = 'Xbricks';

	public function volumes(){
		return $this->hasMany('App\Volume');
	}

	public function cluster(){
		return $this->belongsTo('App\Cluster');
	}

}
