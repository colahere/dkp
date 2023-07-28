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
            $table->string('user_id');
            $table->string('character_id');
            $table->string('score')->default(0);
            $table->integer('status');
            $table->timestamps();
            $table->string('remark')->default(NULL);
            $table->integer('approved')->default(0);
            $table->string('approver')->default(NULL);
            $table->string('supplement_id')->default(NULL);
            
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
