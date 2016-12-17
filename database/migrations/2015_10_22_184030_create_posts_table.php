<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                Schema::create('posts', function(Blueprint $table)
                {
                        $table->increments('id');
						$table->integer('domain_id')->unsigned();
						$table->index('domain_id');
						$table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
						$table->string('title');
						$table->text('description');
						$table->string('source');
						$table->text('keywords');
						$table->string('thumbnail');
						$table->json('custom_fields');
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
                Schema::drop('posts');
        }

}