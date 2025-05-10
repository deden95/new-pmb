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
        Schema::create('item_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('amount')->nullable();
            $table->string('type_payment');
            $table->string('status')->default('0');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_payment');
    }
};
