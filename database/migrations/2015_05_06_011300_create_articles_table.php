<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//creates a table for articles
		Schema::create('articles', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('title');
				$table->text('body');
				$table->timestamps();
				$table->timestamp('published_at');
				$table->integer('user_id')->unsigned();
				$table->string('image_path');
				$table->foreign('user_id')->references('id')->on('users');


			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//drop articles table
		Schema::drop('articles');
	}

}
