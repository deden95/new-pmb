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
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('forms_user_id_foreign');
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place_city')->nullable();
            $table->string('birth_place_province')->nullable();
            $table->string('birth_place_country')->default('Indonesia');
            $table->string('national_id')->nullable();
            $table->boolean('is_color_blind')->nullable();
            $table->boolean('is_disability')->nullable();
            $table->text('disability_note')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('district', 225)->nullable();
            $table->string('country')->default('Indonesia');
            $table->string('postal_code')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone_number_alt')->nullable();
            $table->string('last_education')->nullable();
            $table->string('education_number')->nullable();
            $table->string('education_name')->nullable();
            $table->string('education_city')->nullable();
            $table->string('education_province')->nullable();
            $table->string('education_subdistrict')->nullable();
            $table->string('education_country')->default('Indonesia');
            $table->integer('education_postal_code')->nullable();
            $table->string('education_graduation_year')->nullable();
            $table->string('education_major')->nullable();
            $table->string('education_grade')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_birth_date')->nullable();
            $table->string('father_place')->nullable();
            $table->string('father_last_education')->nullable();
            $table->string('father_job')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_email')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_birth_date')->nullable();
            $table->string('mother_place')->nullable();
            $table->string('mother_last_education')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('mother_email')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_birth_date')->nullable();
            $table->string('guardian_place')->nullable();
            $table->string('guardian_last_education')->nullable();
            $table->string('guardian_job')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->unsignedBigInteger('affiliate_id')->nullable()->index('forms_affiliate_id_foreign');
            $table->string('no_exam')->nullable();
            $table->string('code_registration')->default('0');
            $table->unsignedBigInteger('wave_id')->nullable()->index('forms_wave_id_foreign');
            $table->unsignedBigInteger('option_id')->nullable()->index('forms_option_id_foreign');
            $table->unsignedBigInteger('option_2_id')->nullable()->index('forms_option_2_id_foreign');
            $table->boolean('is_via_online')->default(true);
            $table->boolean('is_lock')->default(false);
            $table->boolean('is_submitted')->default(false);
            $table->text('note')->nullable();
            $table->enum('status', ['waiting', 'submitted', 'pending', 'approved', 'rejected'])->default('waiting');
            $table->text('reason_rejected')->nullable();
            $table->enum('end_status', ['pending', 'submitted', 'approved', 'rejected'])->default('pending');
            $table->timestamp('is_paid_registration')->nullable();
            $table->boolean('is_paid_tuition')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
