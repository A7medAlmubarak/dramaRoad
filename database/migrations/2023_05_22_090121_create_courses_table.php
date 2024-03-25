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
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('online_status')->default(false);
            $table->date('registration_start_date');
            $table->date('registration_end_date')->nullable();
            $table->double('levels_number')->default(0);
            $table->double('payments');
            $table->double('students_number');
            $table->boolean('publish_status')->default(false);
            $table->boolean('finished_status')->default(false);
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
