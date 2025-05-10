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
        Schema::table('forms', function (Blueprint $table) {
            $table->foreign(['affiliate_id'])->references(['id'])->on('affiliates')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['option_2_id'])->references(['id'])->on('prodi')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['option_id'])->references(['id'])->on('prodi')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['wave_id'])->references(['id'])->on('waves')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropForeign('forms_affiliate_id_foreign');
            $table->dropForeign('forms_option_2_id_foreign');
            $table->dropForeign('forms_option_id_foreign');
            $table->dropForeign('forms_user_id_foreign');
            $table->dropForeign('forms_wave_id_foreign');
        });
    }
};
