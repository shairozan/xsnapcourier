<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//Custom Includes
use App\libraries\XSnapCourier;
use App\libraries\VCenterReport;
use App\Volume;
use App\Snapshot;
use App\DataType;
use App\Cluster;
use App\Xbrick;
use App\VolumeStatistic;

class VolumeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$data['volumes'] = Volume::orderBy('xio_volume_name','asc')->get();
		return view('volumes.index')->with($data);
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
		$data['volume_details'] = Volume::find($id);
		$data['snapshots'] = Snapshot::allSnapshotsForVolume($id);
		$data['data_types'] = DataType::all();
		$data['xbrick'] = $data['volume_details']->xbricks;
		$data['headers'] = VolumeStatistic::first();
		$data['volume_utilization'] = XSnapCourier::getVolumeUtilization($data['volume_details']->xio_volume_id);
		return view('volumes.details')->with($data);
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
		$Volume = Volume::find($id);
		foreach(\Request::all() as $k=>$v){
			if( $k=='_method' || $k == '_token'){
				continue;
			}

			$Volume->$k = $v;
		}
		$Volume->save();
		return redirect('/');
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

}
