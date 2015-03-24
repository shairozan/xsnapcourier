<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clusterstat extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ClusterStatistics',function($table){
			$table->increments('id')->unsigned();
			$table->integer('cluster_id')->unsigned();
			$table->foreign('cluster_id')->references('id')->on('Clusters');
			$table->decimal('iops',15,2)->index();
			$table->decimal('small-iops',15,2);
			$table->integer('logical-space-in-use')->index();
			$table->decimal('wr-latency',15,2);
			$table->decimal('rd-latency',15,2);
			$table->decimal('rd-iops',15,2);
			$table->decimal('wr-iops',15,2);
			$table->decimal('avg-latency');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ClusterStatistics');
	}

}
