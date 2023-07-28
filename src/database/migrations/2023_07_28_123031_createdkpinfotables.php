<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createdkpinfotables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dkp_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->default(0);
            $table->string('character_id')->default(0);
            $table->string('score')->default(0);
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->string('remark')->default(0);
            $table->integer('approved')->default(0);
            $table->string('approver')->default(0);
            $table->string('supplement_id')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dkp_info');
    }
}
