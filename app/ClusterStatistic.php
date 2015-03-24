<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ClusterStatistic extends Model {

	protected $table = 'ClusterStatistics';

	static function getIOStatistics($days){
	$stats =\DB::select('CALL cluster_stats(' . $days . ')');


	$retval = '[ ';
	$counter = 1;

	$retval .= "['Date', 'IOPS', 'Read IO', 'Write IO'],";

	foreach($stats as $stat){

			$retval .= '[';
			$retval .= "'" . $stat->udate . "'"; 
			$retval .= ', ';
			$retval .= $stat->max_iops;
			$retval .= ', ';
			$retval .= $stat->rd_iops;
			$retval .= ', ';
			$retval .= $stat->wr_iops;
			$retval .= ']';

			if($counter < (count($stats) ) ){
				$retval .= ',';
			}
			$counter +=1;
		}

	$retval .= ' ] ';

	return $retval;

	}

	static function getSpaceStatistics($days){
	$stats =\DB::select('CALL cluster_stats(?)', 
		array (
			$days
				));

	

	$retval = '[ ';
	$counter = 1;

	$retval .= "['Date', 'Space in GB'],";

	foreach($stats as $stat){

			$retval .= '[';
			$retval .= "'" . $stat->udate . "'"; 
			$retval .= ', ';
			$retval .= $stat->gb;
			$retval .= ']';

			if($counter < (count($stats) ) ){
				$retval .= ',';
			}
			$counter +=1;
		}

	$retval .= ' ] ';

	return $retval;

	}

	

}
