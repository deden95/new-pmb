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
        Schema::create('exam_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_id')->index('exam_histories_exam_id_foreign');
            $table->unsignedBigInteger('user_id')->index('exam_histories_user_id_foreign');
            $table->integer('score')->default(0);
            $table->integer('duration')->default(0);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_finished')->default(false);
            $table->boolean('is_submitted')->default(false);
            $table->string('order_questions')->nullable();
            $table->json('answers')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_histories');
    }
};
