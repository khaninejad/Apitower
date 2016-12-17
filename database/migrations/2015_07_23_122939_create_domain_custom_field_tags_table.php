<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainCustomFieldTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domain_custom_field_tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('domain_custom_fields_id')->unsigned();
			$table->foreign('domain_custom_fields_id')->references('id')->on('domain_custom_fields')->onDelete('cascade');
			$table->integer('domain_feed_id')->unsigned();
			$table->foreign('domain_feed_id')->references('id')->on('domain_feeds')->onDelete('cascade');
			$table->string('domain_custom_field_tag');
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
		Schema::drop('domain_custom_field_tags');
	}

}
