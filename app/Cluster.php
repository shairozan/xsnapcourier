<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model {

	protected $table = 'Clusters';

	public function bricks(){
		return $this->hasMany('App\Xbrick');
	}

}
