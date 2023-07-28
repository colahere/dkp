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
            $table->string('supplement_name')->default(NULL);
            $table->string('all_dkp')->default(NULL);
            $table->string('use_dkp')->default(NULL);
            $table->string('supplement_num')->default(NULL);
            $table->integer('is_use')->default(NULL);
            $table->timestamps();
            $table->string('remark')->default(NULL);
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

