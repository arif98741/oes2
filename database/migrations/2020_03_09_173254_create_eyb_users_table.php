<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEybUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eyb_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_type');
            $table->integer('country_id')->nullable();
            $table->integer('student_grade');
            $table->string('name');
            $table->text('user_mobile')->nullable();
            $table->text('image')->nullable();
            $table->string('email',191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('two_step_verification')->default(0);
            $table->integer('status')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('eyb_users');
    }
}
