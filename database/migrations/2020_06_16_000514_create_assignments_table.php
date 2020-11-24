<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('user_type');
            $table->integer('student_grade')->default(0);
            $table->integer('semester')->default(0);
            $table->integer('section')->default(0);
            $table->integer('subjects')->default(0);
            $table->string('title');
            $table->bigInteger('exam_start');
            $table->bigInteger('exam_end');
            $table->text('assignment');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('assignments');
    }
}
