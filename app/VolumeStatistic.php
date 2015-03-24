<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class VolumeStatistic extends Model {

	protected $table = 'VolumeStatistics';

	public function volumes(){
		return $this->belongsTo('App\Volume');
	}

	static function getStatistics($days){
		return \DB::select('CALL volume_stats(?)', 
		array (
			$days
				));
	}

}
