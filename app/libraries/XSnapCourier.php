<?php

// Created by: Darrell J. Breeden
// For: Comporium Communications
// 2/5/2015


namespace App\libraries;

class XSnapCourier {


	//Cluster Values
	static function getClusters() {
		$URL = 'https://'. \Config::get('app.XtremeIOIP') .'/api/json/types/clusters';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, \Config::get('app.XSnapCredentials.username') . ":" . \Config::get('app.XSnapCredentials.password') );

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

		if(! isset(json_decode($result)->error) ){
			return(json_decode($result)->clusters);
		} else {
			return FALSE;
		}
	}

	static function getClusterDetails($id){
		$URL = 'https://'. \Config::get('app.XtremeIOIP') .'/api/json/types/clusters/' . $id;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, \Config::get('app.XSnapCredentials.username') . ":" . \Config::get('app.XSnapCredentials.password') );

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

		if(! isset(json_decode($result)->error) ){
			return(json_decode($result)->content);
		} else {
			return FALSE;
		}
	}

	static function getClusterByName($name){
		$URL = 'https://'. \Config::get('app.XtremeIOIP') .'/api/json/types/clusters/?name=' . $name;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, \Config::get('app.XSnapCredentials.username') . ":" . \Config::get('app.XSnapCredentials.password') );

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

		if(! isset(json_decode($result)->error) ){
			return json_decode($result)->content;
		} else {
			return FALSE;
		}
	}


	//Brick Values
	static function getBricks() {
		$URL = 'https://'. \Config::get('app.XtremeIOIP') .'/api/json/types/bricks';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, \Config::get('app.XSnapCredentials.username') . ":" . \Config::get('app.XSnapCredentials.password') );

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

		if(! isset(json_decode($result)->error) ){
			return(json_decode($result)->bricks);
		} else {
			return FALSE;
		}
	}

	static function getBrickDetails($id) {
		$URL = 'https://'. \Config::get('app.XtremeIOIP') .'/api/json/types/bricks/' . $id;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, \Config::get('app.XSnapCredentials.username') . ":" . \Config::get('app.XSnapCredentials.password') );

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

		if(! isset(json_decode($result)->error) ){
			return(json_decode($result)->content);
		} else {
			return FALSE;
		}
	}


	//VOLUME FUNCTIONS

	//GET to REST APIs to list volumes and their IDs
	static function getVolumes() {
		$URL = 'https://'. \Config::get('app.XtremeIOIP') .'/api/json/types/volumes';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, \Config::get('app.XSnapCredentials.username') . ":" . \Config::get('app.XSnapCredentials.password') );

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

		if(! isset(json_decode($result)->error) ){
			return(json_decode($result)->volumes);
		} else {
			return FALSE;
		}
	}


	static function getVolumeDetails($volume_id){
		$URL = 'https://'. \Config::get('app.XtremeIOIP') . '/api/json/types/volumes/' . $volume_id;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, \Config::get('app.XSnapCredentials.username') . ":" . \Config::get('app.XSnapCredentials.password') );

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

		if(! isset(json_decode($result)->error) ){
			return(json_decode($result)->content);
		} else {
			return FALSE;
		}
	}

	static function getVolumeUtilization($volume_id){
		$URL = 'https://'. \Config::get('app.XtremeIOIP') . '/api/json/types/volumes/' . $volume_id;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, \Config::get('app.XSnapCredentials.username') . ":" . \Config::get('app.XSnapCredentials.password') );

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

		if(! isset(json_decode($result)->error) ){
			$space_details = json_decode($result);
			$desired = array ('vol-size','logical-space-in-use');
			return round((($space_details->content->$desired[1]/$space_details->content->$desired[0]) * 100),0) ;
		} else {
			return FALSE;
		}
	}


	
	
	// SNAPSHOT FUNCTIONS

	// POST to REST API for creating snapshots
	static function createSnapshot($volume_name, $snapshot_name, $folder = null) {
		$URL = 'https://'. \Config::get('app.XtremeIOIP') . '/api/json/types/snapshots';

		//There are issues using attributes with a "-"
		//In the name, so we access them via variable
		//instead.
		$source_name_mask = 'ancestor-vol-id';
		$snap_name_mask = 'snap-vol-name';
		$folder_name_mask = 'folder_id';

		//We require a single JSON object to pass through CURL
		//So we will instantiate a stdClass object and then
		//JsonEncode it for transmission.
		$postObject = new \stdClass();
		$postObject->$source_name_mask = $volume_name;
		$postObject->$snap_name_mask = $snapshot_name;
		if( ! $folder ){
			if(\Config::get('app.DefaultSnapDir')){
				$postObject->$folder_name_mask = \Config::get('app.DefaultSnapDir');
			} 
		}


		$postvalue = json_encode($postObject);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, \Config::get('app.XSnapCredentials.username') . ":" . \Config::get('app.XSnapCredentials.password') );
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postvalue);

		$result = curl_exec($ch);
		$usable_result = json_decode($result);

		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

		\Log::info(print_r($usable_result,TRUE));

		if(! isset($usable_result->error) ){
			//For some reason, in the response from the XIO
			//the Links attribute is an array of objects as opposed
			//to an object composed of objects. 

			//As such we must pull links[0]->href to get the data we need
			$components = explode('/',$usable_result->links[0]->href);
			return $components[count($components) - 1];
		} else {
			return FALSE;
		}
	}


	// DELETE to REST API for deleting snapshots
	//	$snapshot_id: The XtremeIO ID for the snapshot we are going to delete.
	static function deleteSnapshot($snapshot_id) {
		$URL = 'https://'. \Config::get('app.XtremeIOIP') . '/api/json/types/snapshots/' . $snapshot_id;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, \Config::get('app.XSnapCredentials.username') . ":" . \Config::get('app.XSnapCredentials.password') );

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

		if( $status_code >= 200 && $status_code <400){
			return TRUE;
		} else {
			\Log::error('Request to delete snapshot with id of ' . $snapshot_id . ' has failed with an error code of ' . $status_code);			
			return FALSE;
		}

	}





	//Auxiliary functions
	static function getDiskDetails($brick_id){
		$target = 'ssd-slot-array';
		if ($bricks = XSnapCourier::getBrickDetails($brick_id)){
			$disks = array();
			
			foreach($bricks->$target as $disk_object){
				$disks[] = $disk_object;
			}

			return $disks;
		}
		
	}

}