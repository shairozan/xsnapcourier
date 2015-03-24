<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\libraries\XSnapCourier;
use App\Volume;
use App\Cluster;
use App\VolumeStatistic;
use App\ClusterStatistic;
use App\Setting;

class StatisticsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
		//
	}

	public function processStatistics(){

		//Now let's go ahead and see if we can sync volumes
		Volume::syncVolumes();

		//First we check to see if we're even supposed to do anything:
		if( ! Setting::getSetting('SCHEDULER_ENABLED') ) {
			\Log::error('Scheduler is not currently enabled. Aborting statistics collection');
			exit;
		}

		$desired = array(
			'iops',
			'small-iops',
			'logical-space-in-use',
			'wr-latency',
			'rd-latency',
			'rd-iops',
			'wr-iops',
			'avg-latency',
			);

		$volumes = Volume::statisticsVolumes();
		$clusters = Cluster::all();

		foreach($volumes as $volume){
			$Statistic = new VolumeStatistic();
			$Statistic->volume_id = $volume->id;
			$details = XSnapCourier::getVolumeDetails($volume->xio_volume_id);
			foreach($desired as $d){
				$Statistic->$d = $details->$d;
			}
			$Statistic->save();
		}

		foreach($clusters as $cluster){
			//We don't store the Cluster ID for XIO so we have to pull it down
			$details = XSnapCourier::getClusterByName($cluster->cluster_name);	

			$Statistic = new ClusterStatistic();
			foreach($desired as $d){
				if($d == 'logical-space-in-use'){
					//The cluster can provide on disk data as opposed to 
					//Logical data like the disk. For this reason we'll
					//Use the same DB field, but set the value
					//Based on the ud-ssd-space-in-use attribute
					$tvalue = 'ud-ssd-space-in-use';
					$Statistic->$d = $details-> $tvalue;
				} else {				
					$Statistic->$d = $details->$d;
					}
			}

			$Statistic->cluster_id = $cluster->id;
			$Statistic->save();
		}
	}

}
