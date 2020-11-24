<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEybModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eyb_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('module_name');
            $table->string('creator_name');
            $table->integer('subjects');
            $table->integer('chapter');
            $table->integer('country')->nullable();
            $table->integer('student_grade');
            $table->integer('module_type');
            $table->integer('user_id');
            $table->integer('user_type');
            $table->date('exam_date')->nullable();
            $table->date('exam_start')->nullable();
            $table->date('exam_end')->nullable();
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
        Schema::dropIfExists('eyb_modules');
    }
}
