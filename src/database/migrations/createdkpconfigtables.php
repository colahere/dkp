<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createdkpconfigtables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dkp_config', function (Blueprint $table) {
            $table->interger('id');
            $table->string('name');
	    $table->string('level');
	    $table->string('score');
	    $table->string('station');
	    $table->string('ship_num');
	    $table->string('label');
	    $table->datetime('created_at');
	    $table->datetime('updated_at');
	    $table->string('remark');
	    $table->string('level');

		
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dkp_config');
    }
}

