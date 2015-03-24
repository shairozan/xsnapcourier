<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//Helpers
use App\libraries\XSnapCourier;

//Models
use App\Volume;
use App\Snapshot;
use App\Setting;

class SnapshotController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		echo "Meow";
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('snapshots.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		print_r(\Request::all());

		if( $snapshot = XSnapCourier::createSnapshot(\Request::get('volume_name'), \Request::get('snapshot_name') )) {
			echo "Created successfully";
			print_r($snapshot);
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//Locate the Snapshot Object
		$snapshot = Snapshot::find($id);
		if(XSnapCourier::deleteSnapshot($snapshot->xio_snapshot_id)){
			if($snapshot->delete()){
				return redirect('/');
			}
		}
	}

	public function enableSchedule(){
	$Setting = Setting::where('SETTING_NAME','SCHEDULER_ENABLED')->first();
		$Setting->SETTING_VALUE=1;
		$Setting->save();
		return redirect('/');
	}

	public function disableSchedule(){
		$Setting = Setting::where('SETTING_NAME','SCHEDULER_ENABLED')->first();
		$Setting->SETTING_VALUE=0;
		$Setting->save();
		return redirect('/');
	}

	public function processSchedule(){

		//First we check to see if we're even supposed to do anything:
		if( ! Setting::getSetting('SCHEDULER_ENABLED') ) {
			\Log::error('Scheduler is not currently enabled. Aborting snapshot processing');
			exit;
		}

		//Return all Snappable volumes and their associated data type / snap details
		$volumes = Volume::snappableVolumes();
		
		foreach($volumes as $volume){

			if( Snapshot::snapshotsForVolume($volume->id) == 0){
				//No Snapshots Exist. Let us establish snapshots
				\Log::info('No snapshots exist for Volume ' . $volume->xio_volume_name . '. Requesting Snapshot Creation');

				Snapshot::processSnapshot($volume->xio_volume_name,$volume->id);
			}

			//New Snaps :: Evaluate if we are X Frames past last snap
				$newest_snap = Snapshot::newestSnapshotForVolume($volume->id);
				$carbon_method = 'add' . ucfirst($volume->snap_time_frame) . 's';

				$snapdate = \Carbon\Carbon::parse($newest_snap->created_at);
				$nextSnapDate = $snapdate->$carbon_method($volume->snap_time_value)->subMinutes(45);


				if( ! \Carbon\Carbon::parse($nextSnapDate)->isPast() ){
					\Log::info('We are still within the snap frame for volume ' . $volume->xio_volume_name . '. No need to snap again');
				} else {
					\Log::info('Past time for a previously designated snap for volume ' . $volume->xio_volume_name . '. Beginning to process snapshot');
					Snapshot::processSnapshot($volume->xio_volume_name, $volume->id);
				}


			//Old Snaps :: Evaluate any Snaps that are older than our max frames
				$oldest_snap = Snapshot::oldestSnapshotForVolume($volume->id);
				$carbon_method = 'add' . ucfirst($volume->retention_time_frame) . 's';
				
				$snapdate = \Carbon\Carbon::parse($oldest_snap->created_at);
				$purge_date = $snapdate->$carbon_method($volume->retention_time_value);

				if ( ! \Carbon\Carbon::parse($purge_date)->isPast()){
					\Log::info('Snap ' . $oldest_snap->name . ' does not need to be purged');
				} else {
					Snapshot::purgeSnapshot($oldest_snap->id);
				}

		}
	}

	public function manualSnapshot($id){
		$volume_details = Volume::find($id);
		if(Snapshot::processSnapshot($volume_details->xio_volume_name, $volume_details->id, 'Manual')){
			return redirect('/');
		} else {
			\Log::error('There was an issue attempting to process a snapshot on volume ' . $volume_details->xio_volume_name);
		}
	}

}
