<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ondemandsnaps extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Snapshots',function($table){
			$table->boolean('scheduled')->after('xio_snapshot_id')->default('1');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Snapshots',function($table){
			$table->dropColumn('scheduled');
		});
	}

}
