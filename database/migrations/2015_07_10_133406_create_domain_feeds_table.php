<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainFeedsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domain_feeds', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('domain_id')->unsigned();
			$table->index('domain_id');
			$table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
			$table->integer('domain_category')->unsigned();
			$table->index('domain_category');
			$table->string('domain_url');
			$table->string('domain_feed');
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
		Schema::drop('domain_feeds');
	}

}
