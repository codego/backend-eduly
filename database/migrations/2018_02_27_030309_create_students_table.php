<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id')->index();;
            $table->string('name');
            $table->string('lastname');
            $table->string('document');
            $table->string('degree')->nullable();
            $table->string('gender');
            $table->string('phone')->nullable();
            $table->string('address');
            $table->string('locality');
            $table->string('city');
            $table->string('province');
            $table->string('place_birth');
            $table->string('place_residence');
            $table->string('email');
            $table->integer('status');
            $table->string('group_by')->nullable();
            $table->date('entry');
            $table->date('egress')->nullable();
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
        Schema::dropIfExists('students');
    }
}
