<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_subscriptions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->index('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('event_name');
			$table->string('event_type');
			$table->timestamp('trigged');
			$table->integer('period');
			$table->enum('state', ['enable', 'disable']);
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
		Schema::drop('event_subscriptions');
	}

}
