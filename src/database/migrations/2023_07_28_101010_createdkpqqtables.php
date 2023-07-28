<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createdkpqqtables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    Schema::create('dkp_QQ', function (Blueprint $table) {
        $table->integer('id');
        $table->string('QQ')->default(0);
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

        Schema::dropIfExists('dkp_QQ');

    }
}

