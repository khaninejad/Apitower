<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainCustomFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domain_custom_fields', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('domain_id')->unsigned();
			$table->index('domain_id');
			$table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
			$table->integer('domain_custom_fields_key_id');
			$table->string('domain_custom_fields_key');
			$table->string('domain_custom_fields_value');
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
		Schema::drop('domain_custom_fields');
	}

}
