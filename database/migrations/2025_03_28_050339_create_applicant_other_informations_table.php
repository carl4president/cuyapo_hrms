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
        Schema::create('applicant_other_informations', function (Blueprint $table) {
            $table->id();
            $table->string('app_id'); 
            $table->foreign('app_id')->references('app_id')->on('applicants')->onDelete('cascade');

            $table->text('special_skills_hobbies')->nullable();
            $table->text('non_academic_distinctions')->nullable();
            $table->text('membership_associations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_other_information');
    }
};
