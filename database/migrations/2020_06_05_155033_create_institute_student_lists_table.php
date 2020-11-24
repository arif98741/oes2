<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstituteStudentListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institute_student_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('institute_id');
            $table->integer('user_id');
            $table->integer('roll_no');
            $table->integer('level');
            $table->integer('section');
            $table->integer('semester');
            $table->text('create_date');
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
        Schema::dropIfExists('institute_student_lists');
    }
}
