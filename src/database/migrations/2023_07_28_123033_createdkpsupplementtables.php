<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createdkpsupplementtables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dkp_supplement', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supplement_name')->default(0);
            $table->string('all_dkp')->default(0);
            $table->string('use_dkp')->default(0);
            $table->string('supplement_num')->default(0);
            $table->integer('is_use')->default(0);
            $table->timestamps();
            $table->string('remark')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dkp_supplement');
    }
}

