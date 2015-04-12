<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGachaLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_gacha_logs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('gacha_type_id');
			$table->integer('coin_spend');
			$table->integer('item_id');
			$table->integer('item_rarity');

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
		Schema::drop('user_gacha_logs');
	}

}
