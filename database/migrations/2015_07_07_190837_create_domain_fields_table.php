<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domain_fields', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('domain_id')->unsigned();
			$table->index('domain_id');
			$table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
			$table->string('title');
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
		Schema::drop('domain_fields');
	}

}
