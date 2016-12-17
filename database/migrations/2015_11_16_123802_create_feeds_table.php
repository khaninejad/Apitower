<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                Schema::create('feeds', function(Blueprint $table)
                {
                        $table->increments('id');
						$table->integer('feeds_id')->unsigned();
						$table->index('feeds_id');
						$table->foreign('feeds_id')->references('id')->on('domain_feeds')->onDelete('cascade');
						$table->string('feed_title');
						$table->string('feed_url');
						$table->string('feed_description');
						$table->enum('feed_state', ['unread', 'read','posted'])->default('unread');
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
                Schema::drop('feeds');
        }

}