<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainTxnmsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domain_txnms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('domain_taxonomies_id')->unsigned();
			$table->foreign('domain_taxonomies_id')->references('id')->on('domain_taxonomies')->onDelete('cascade');
			$table->string('title');
			$table->string('txid');
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
		Schema::drop('domain_txnms');
	}

}
