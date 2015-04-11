<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGachasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gachas', function(Blueprint $table)
		{
			$table->integer('id');
			$table->string('name');
			$table->string('description');
			$table->integer('price');
			$table->integer('free_draw_reset_duration');
			$table->integer('common_prob');
			$table->integer('uncommon_prob');
			$table->integer('rare_prob');
			$table->integer('super_rare_prob');
			$table->timestamps();

			$table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gachas');
	}

}
