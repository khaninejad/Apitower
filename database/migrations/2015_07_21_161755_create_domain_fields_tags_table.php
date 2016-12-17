<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainFieldsTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domain_fields_tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('domain_fields_id')->unsigned();
			$table->foreign('domain_fields_id')->references('id')->on('domain_fields')->onDelete('cascade');
			$table->integer('domain_feed_id')->unsigned();
			$table->foreign('domain_feed_id')->references('id')->on('domain_feeds')->onDelete('cascade');
			$table->string('domain_field_tag');
			$table->enum('type', array('tag', 'value'))->default('value');
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
		Schema::drop('domain_fields_tags');
	}

}
