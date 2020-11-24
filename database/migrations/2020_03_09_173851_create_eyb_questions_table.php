<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEybQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eyb_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('question_type');
            $table->integer('chapter');
            $table->integer('subjects');
            $table->integer('user_id');
            $table->integer('student_grade');
            $table->string('question_name');
            $table->string('question_time');
            $table->string('question_description');
            $table->double('mark', 8, 2);
            $table->text('answer');
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
        Schema::dropIfExists('eyb_questions');
    }
}
