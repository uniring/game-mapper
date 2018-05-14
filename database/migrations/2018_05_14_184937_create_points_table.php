<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePointsTable extends Migration {

	public function up()
	{
		Schema::create('points', function(Blueprint $table) {
			$table->increments('id');
			$table->enum('type', array('npc', 'enemy', 'trigger', 'warp'));
			$table->string('name');
			$table->integer('map_x');
			$table->string('map_y');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('points');
	}
}