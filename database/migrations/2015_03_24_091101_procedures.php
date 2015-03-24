<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class procedures   extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//VolumeStatistics Procedure
		$sql = <<<SQL
		CREATE PROCEDURE `volume_stats`(IN days INT)
		BEGIN
        	select                  distinct date(created_at) as udate,
                                        round((select max(iops) from VolumeStatistics where date(created_at) = udate),2) as max_iops,
                                        round((select max(`rd-iops`) from VolumeStatistics where date(created_at) = udate),2) as rd_iops,
                                        round((select max(`wr-iops`) from VolumeStatistics where date(created_at) = udate),2) as wr_iops,
                                        round((select max(`logical-space-in-use`) from VolumeStatistics where date(created_at) = udate) /1024 /1024,2) as gb,
                                        round((select avg(`avg-latency`) from VolumeStatistics where date(created_at) = udate),2) as total_latency,
                                        round((select avg(`rd-latency`) from VolumeStatistics where date(created_at) = udate),2) as rd_latency,
                                        round((select avg(`wr-latency`) from VolumeStatistics where date(created_at) = udate),2) as wr_latency
	        from                    VolumeStatistics vs
	        where                   created_at > date_sub(now(),interval days day);
		END
SQL;

		DB::connection()->getPdo()->exec($sql);



		//Cluster Stats Procedure
		$sql = <<<SQL
		CREATE PROCEDURE `cluster_stats`(IN days INT)
		BEGIN

        select                  distinct date(created_at) as udate,
                                        round((select max(iops) from ClusterStatistics where date(created_at) = udate),2) as max_iops,
                                        round((select max(`rd-iops`) from ClusterStatistics where date(created_at) = udate),2) as rd_iops,
                                        round((select max(`wr-iops`) from ClusterStatistics where date(created_at) = udate),2) as wr_iops,
                                        round((select max(`logical-space-in-use`) from ClusterStatistics where date(created_at) = udate) /1024 /1024,2) as gb,
                                        round((select avg(`avg-latency`) from ClusterStatistics where date(created_at) = udate),2) as total_latency,
                                        round((select avg(`rd-latency`) from ClusterStatistics where date(created_at) = udate),2) as rd_latency,
                                        round((select avg(`wr-latency`) from ClusterStatistics where date(created_at) = udate),2) as wr_latency
        from                    ClusterStatistics vs
        where                   created_at > date_sub(now(),interval days day);
		END 
SQL;

		DB::connection()->getPdo()->exec($sql);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$sql = 'DROP PROCEDURE IF EXISTS volume_stats';
		DB::connection()->getPdo()->exec($sql);

		$sql = 'DROP PROCEDURE IF EXISTS cluster_stats';
		DB::connection()->getPdo()->exec($sql);
	}

}
