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
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('duration')->default(60);
            $table->json('allowed')->nullable();
            $table->boolean('shuffle_question')->default(false);
            $table->boolean('shuffle_answer')->default(false);
            $table->boolean('show_result')->default(false);
            $table->string('access_start_time')->nullable();
            $table->string('access_end_time')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
