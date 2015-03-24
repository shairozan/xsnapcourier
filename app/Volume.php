<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\libraries\XSnapCourier;

class Volume extends Model {


	protected $table = 'Volumes';

	public function xbricks(){
		return $this->belongsTo('App\Xbrick');
	}

	public function statistics(){
		return $this->hasMany('App\VolumeStatistic');
	}

	static function snappableVolumes(){
		return \DB::table('Volumes as v')
					->join('DataTypes as d','v.data_type_id','=','d.id')
					->select('v.id', 'v.xio_volume_id','v.xio_volume_name', 'v.snaps_enabled', 'v.statistics_enabled', 'v.created_at as volume_creation', 'd.name','d.snap_time_value','d.snap_time_frame','d.retention_time_value','d.retention_time_frame','d.created_at')
					->where('v.xio_volume_name','not like','%ESX%')
					->where('v.snaps_enabled',1)
					->orderBy('v.xio_volume_name','asc')
					->get();
	}

		static function statisticsVolumes(){
		return \DB::table('Volumes as v')
					->join('DataTypes as d','v.data_type_id','=','d.id')
					->select('v.id', 'v.xio_volume_id','v.xio_volume_name', 'v.snaps_enabled', 'v.statistics_enabled', 'v.created_at as volume_creation', 'd.name','d.snap_time_value','d.snap_time_frame','d.retention_time_value','d.retention_time_frame','d.created_at')
					->where('v.xio_volume_name','not like','%ESX%')
					->where('v.statistics_enabled',1)
					->orderBy('v.xio_volume_name','asc')
					->get();
	}

	static function syncVolumes(){

		if(\App\Volume::count() == 0 ){
			\Log::info('No existing definitions found. Defining base structure');
			
			//First let's get our default data type
			$DataType = DataType::where('name',\Config::get('app.DefaultDataType'))->first()->id;

			//Now let's populate clusters
			$Clusters = XSnapCourier::getClusters();

			foreach($Clusters as $cluster){
				$clus_obj = new Cluster();
				$clus_obj->cluster_name = $cluster->name;
				$clus_obj->save();
			}

			$default_cluster_id = Cluster::first()->id;


			//Then we need the brick
			$Bricks = XSnapCourier::getBricks();

			foreach($Bricks as $brick){
				$brick_obj = new XBrick();
				$brick_obj->cluster_id = $default_cluster_id;
				$brick_obj->xbrick_name = $brick->name;
				$brick_obj->statistics_enabled = 1;
				$brick_obj->save();
			}

			$default_brick_id = Xbrick::first()->id;

			//Then we set the volumes
			$volumes = XSnapCourier::getVolumes();

			foreach($volumes as $volume){
				$components = explode('/',$volume->href);
				$id = $components[count($components) - 1];

				$vol_object = new Volume();
				$vol_object->xbrick_id = $default_brick_id;
				$vol_object->data_type_id = $DataType;
				$vol_object->xio_volume_id = $id;
				$vol_object->xio_volume_name = $volume->name;
				$vol_object->save();
			}

		\Log::info('Successfully performed initial synchronization');
		echo "Sync Complete";
		} else {
			
			\Log::info("Volumes defined. Checking for additional volumes");
			$RecordedVolumes = Volume::all();
			$comparison = array();
			
			foreach($RecordedVolumes as $rv){
				$comparison[] = $rv->xio_volume_name;
			}

			foreach(XSnapCourier::getVolumes() as $volume){
				//Check to see if the volume doesn't already exist

				if(! in_array($volume->name,$comparison)){

					//Check for snaps (listed in volume output)
					if(preg_match('/SNAP/',$volume->name)){
						\Log::info('Volume ' . $volume->name . ' matches predefined pattern for snaps and will not be added');
						continue;
					}

					\Log::info('New volume detected. Beginning addition');

					$components = explode('/',$volume->href);
					$id = $components[count($components) - 1];

					$vol_object = new Volume();
					$vol_object->xbrick_id = Xbrick::first()->id;
					$vol_object->data_type_id = DataType::first()->id;
					$vol_object->xio_volume_id = $id;
					$vol_object->xio_volume_name = $volume->name;
					$vol_object->snaps_enabled = 0;
					$vol_object->statistics_enabled = 0;
					$vol_object->save();

					\Log::info('Volume ' . $vol_object->xio_volume_name . ' has been recorded');
				} 
			}
		}
	}

}
