<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\libraries\XSnapCourier;

class Snapshot extends Model {

	protected $table = 'Snapshots';

	static function snapshotsForVolume($volume_id){
		return \DB::table('Snapshots')->where('volume_id',$volume_id)->where('name','not like','%MANUAL%')->count();
	}

	static function allSnapshotsForVolume($volume_id){
		return \DB::table('Snapshots')->where('volume_id',$volume_id)->get();
	}

	static function allSnapshots(){
		return \DB::table('Snapshots')->get();
	}

	static function newestSnapshotForVolume($volume_id){
		return \DB::table('Snapshots')->where('volume_id',$volume_id)->where('name','not like','%MANUAL%')->where('scheduled',1)->orderBy('created_at','desc')->first();
	}

	static function oldestSnapshotForVolume($volume_id){
		return \DB::table('Snapshots')->where('volume_id',$volume_id)->where('name','not like','%MANUAL%')->where('scheduled',1)->orderBy('created_at','asc')->first();
	}

	static function processSnapshot($volume_name, $volume_id, $snapshot_type = 'Scheduled'){
		\Log::info('Snapshot processing begins: Snapshot type is defined as ' . $snapshot_type);
		if( $snapshot_type == 'Scheduled'){
			$snapshot_name = 'SNAP_' . $volume_name . '_' .  date('Ymdhis');
		} else {
			$snapshot_name = 'MANUAL_SNAP_' . $volume_name . '_' . date('Ymdhis');
		}

		if($snapshot_id = XSnapCourier::createSnapshot($volume_name, $snapshot_name)) {

			\Log::info('Volume ' . $volume_name. ' has been snapshot to id ' . $snapshot_id);
			//Record the snapshot in the DB
			$snap_object = new Snapshot();
			$snap_object->volume_id = $volume_id;
			//Conditionally set scheduled bit
			if(  $snapshot_type !== 'Scheduled'){
				$snap_object->scheduled=0;
			}
			$snap_object->xio_snapshot_id = $snapshot_id;
			$snap_object->name = $snapshot_name;
			$snap_object->save();
			return $snap_object->id;
		} else {
			\Log::error('Volume ' . $volume->xio_volume_name . ' could not be snapshot');
			return false;
		}	
	}

	static function purgeSnapshot($snapshot_id){
		$snapshot = Snapshot::find($snapshot_id);

		if( XSnapCourier::deleteSnapshot($snapshot->xio_snapshot_id)){
			\Log::info('Snapshot with internal ID of ' . $snapshot->xio_snapshot_id . ', name of : ' . $snapshot->name . ' has been removed from the cluster');
			$snapshot->delete();
			\Log::info('Removed DB entry for snapshot ' . $snapshot->name);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	static function snapshotDates(){
		$dates = \DB::select( \DB::raw('select date_format(created_at,\'%Y-%c-%e\') as date from Snapshots;') );
		$date_count = count($dates) - 1 ;
		$counter = 0;
		$return_string="";

		foreach($dates as $date){
			$return_string .= '"' . $date->date . '"';
			if( $counter < $date_count){
				$return_string .= ', ';
			}
			$counter += 1;
		}

		return $return_string;
	}

}
