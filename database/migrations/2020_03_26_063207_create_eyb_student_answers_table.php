<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEybStudentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eyb_student_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_id');
            $table->integer('level_id');
            $table->integer('module_id');
            $table->integer('module_type');
            $table->bigInteger('module_time')->nullable();;
            $table->bigInteger('ans_time')->nullable();;
            $table->double('module_mark');
            $table->double('student_mark');
            $table->longText('student_answer');
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
        Schema::dropIfExists('eyb_student_answers');
    }
}
