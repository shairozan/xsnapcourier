<?php

// Created by: Darrell J. Breeden
// For: Comporium Communications
// 2/5/2015


namespace App\libraries;

class VCenterReport {


	static function getStorageDetails() {
		$URL = 'http://vreports.comporium.com/storedetails';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);
		return json_decode($result);		
	}


	static function getHostDetails() {
		$URL = 'http://vreports.comporium.com/hostdetails';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

		$result = curl_exec($ch);
		$status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);
		return json_decode($result);		
	}
	

}