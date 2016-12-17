<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMixerMainFieldsTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                Schema::create('mixer__main_fields', function(Blueprint $table)
                {
                        $table->increments('id');
						$table->integer('domain_field_id')->unsigned();
						$table->index('domain_field_id');
						$table->foreign('domain_field_id')->references('id')->on('domain_fields')->onDelete('cascade');
						$table->integer('feed_id')->unsigned();
						$table->index('feed_id');
						$table->foreign('feed_id')->references('id')->on('domain_feeds')->onDelete('cascade');
						$table->enum('postfix', array('before', 'after'))->default('before');
						$table->enum('type', array('tag', 'value'))->default('value');
						$table->string('field_tag');
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
                Schema::drop('mixer__main_fields');
        }

}