<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestRequiresTable extends Migration {

	public function up()
	{
		Schema::create('quest_requires', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('quest_id')->unsigned();
			$table->integer('required_quest_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('quest_requires');
	}
}