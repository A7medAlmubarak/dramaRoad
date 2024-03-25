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
        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('shift_type');
            // 1-morning  2-afternoon  3-evening

            $table->text('school_schedule')->default('0');
            $table->integer('level_number');
            $table->boolean('finished_status')->default(false);

            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
