<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialLoad extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('DataTypes',function($table){
			$table->increments('id')->unsigned();
			$table->string('name',128);
			$table->integer('snap_time_value')->nullable();
			$table->string('snap_time_frame',32)->nullable();
			$table->integer('retention_time_value')->nullable();
			$table->string('retention_time_frame',32)->nullable();
			$table->timestamps();
		});

		Schema::create('Clusters',function($table){
			$table->increments('id')->unsigned();
			$table->string('cluster_name',32);
			$table->timestamps();
		});


		Schema::create('Xbricks',function($table){
			$table->increments('id')->unsigned();
			$table->integer('cluster_id')->unsigned();
			$table->foreign('cluster_id')->references('id')->on('Clusters')->onDelete('cascade');
			$table->string('xbrick_name',64);
			$table->boolean('statistics_enabled')->default('1')->nullable();
			$table->string('brick_state',32)->nullable();
			$table->string('ip_address',24)->nullable();
			$table->timestamps();
		});

		Schema::create('Volumes',function($table){
			$table->increments('id')->unsigned();
			$table->integer('xbrick_id')->unsigned();
			$table->foreign('xbrick_id')->references('id')->on('Xbricks')->onDelete('cascade');
			$table->integer('data_type_id')->unsigned();
			$table->foreign('data_type_id')->references('id')->on('DataTypes');
			$table->integer('xio_volume_id')->nullable();
			$table->string('xio_volume_name',32);
			$table->string('friendly_name',128)->nullable();
			$table->boolean('snaps_enabled')->default('1');
			$table->boolean('statistics_enabled')->default('1');
			$table->timestamps();
		});

		Schema::create('Snapshots',function($table){
			$table->increments('id')->unsigned();
			$table->integer('volume_id')->unsigned();
			$table->foreign('volume_id')->references('id')->on('Volumes');
			$table->integer('xio_snapshot_id');
			$table->string('name',64);
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
		Schema::dropIfExists('Snapshots');
		Schema::dropIfExists('Volumes');
		Schema::dropIfExists('Xbricks');
		Schema::dropIfExists('Clusters');
		Schema::dropIfExists('DataTypes');
	}

}
