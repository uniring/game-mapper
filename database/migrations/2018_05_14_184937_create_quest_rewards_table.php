<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestRewardsTable extends Migration {

	public function up()
	{
		Schema::create('quest_rewards', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('quest_id')->unsigned();
			$table->string('name');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('quest_rewards');
	}
}