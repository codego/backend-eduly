<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrelativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correlatives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_subject');
            $table->integer('id_subject_dependence');
            $table->timestamps();
        });

        Schema::table('priorities', function($table) {
            $table->foreign('id_subject')->references('id')->on('subjects');
            $table->foreign('id_subject_dependence')->references('id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('correlatives');
    }
}
