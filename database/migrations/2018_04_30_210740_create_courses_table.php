<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->date('init');
            $table->date('finish');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('teacher_id');
            $table->foreign('subject_id')->references('id')->on('subjects');;
            $table->foreign('teacher_id')->references('id')->on('teachers');;
            $table->timestamps();
        });

        Schema::create('calendar_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->integer('day_week');
            $table->integer('hour_init');
            $table->integer('hour_finish');
            $table->integer('classroom');
            $table->integer('periodicity');
            $table->foreign('course_id')->references('id')->on('courses');;
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
        Schema::dropIfExists('courses');
    }
}
