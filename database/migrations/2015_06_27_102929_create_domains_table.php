<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domains', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->index('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		    $table->string('domain_title');
			$table->string('domain_url');
			$table->string('domain_endpoint');
			$table->enum('domain_type', ['wordpress', 'drupal','custom']);
			$table->string('domain_user');
			$table->string('domain_password');
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
		Schema::dropIfExists('domains');
	}

}
