<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWaypointsTable extends Migration {

	public function up()
	{
		Schema::create('waypoints', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('quest_id')->unsigned();
			$table->integer('point_id')->unsigned();
			$table->mediumText('text');
			$table->enum('mode', array('sync', 'parallel'));
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('waypoints');
	}
}