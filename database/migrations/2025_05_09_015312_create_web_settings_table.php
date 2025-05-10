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
        Schema::create('web_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('site_name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('title_home')->nullable();
            $table->string('title_dashboard')->nullable();
            $table->string('title_exam')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('institution_short_name')->nullable();
            $table->string('institution_synopsis')->nullable();
            $table->text('institution_vision_mission')->nullable();
            $table->text('institution_history')->nullable();
            $table->json('institution_superioty')->nullable();
            $table->json('institution_cooperate')->nullable();
            $table->text('footer')->nullable();
            $table->string('link_univ')->nullable();
            $table->string('contact_telp')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_fax')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('contact_maps', 1000)->nullable();
            $table->string('contact_maps_link', 1000)->nullable();
            $table->string('contact_facebook')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_instagram')->nullable();
            $table->string('contact_twitter')->nullable();
            $table->string('contact_youtube')->nullable();
            $table->string('payment_bank')->nullable();
            $table->string('payment_account')->nullable();
            $table->string('payment_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
