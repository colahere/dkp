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
        $table->integer('id');
        $table->string('name')->default(0);
	    $table->string('level')->default(0);
	    $table->string('score');
	    $table->string('station')->default(0);
	    $table->integer('ship_num')->default(0);
	    $table->string('label');
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
        Schema::dropIfExists('dkp_config');

    }
}

