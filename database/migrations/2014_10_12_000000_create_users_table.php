<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('avatar');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->integer('role_id')->unsigned()->default(5);
            // role 1-admin  2-mod  3-teacher  4-student  5-user

            $table->integer('gender_id')->unsigned();
            $table->foreign('gender_id')->references('id')->on('genders')->cascadeOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
