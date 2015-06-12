<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlliancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('alliances', function(Blueprint $table)
        {
            $table->integer('id');
            $table->string('name');
            $table->string('ticker');
            $table->integer('executor_corp_id');
            $table->integer('members');
            $table->datetime('start_date');
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
		Schema::drop('contacts');
	}

}
