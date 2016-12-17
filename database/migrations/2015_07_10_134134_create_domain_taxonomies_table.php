<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainTaxonomiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domain_taxonomies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('domain_id')->unsigned();
			$table->index('domain_id');
			$table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
			$table->string('domain_taxonomy_type');
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
		Schema::drop('domain_taxonomies');
	}

}
