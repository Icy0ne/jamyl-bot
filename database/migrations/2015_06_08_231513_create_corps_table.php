<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('corps', function(Blueprint $table)
        {
            $table->integer('id');
            $table->string('name');
            $table->integer('alliance_id');
            $table->string('alliance_name');
            $table->string('ticker', 5);
            $table->integer('ceo_id');
            $table->string('ceo_name');
            $table->dateTime('next_check')->nullable();
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
		Schema::drop('corps');
	}

}
