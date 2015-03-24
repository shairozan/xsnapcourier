<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

	protected $table = 'Settings';

	static function getSetting($setting_name){
		return \DB::table('Settings')->where('SETTING_NAME',$setting_name)->pluck('SETTING_VALUE');
	}

}
