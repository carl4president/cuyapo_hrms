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
        Schema::create('applicant_civil_service_eligibility', function (Blueprint $table) {
            $table->id();
            $table->string('app_id'); 
            $table->foreign('app_id')->references('app_id')->on('applicants')->onDelete('cascade');

            $table->string('eligibility_type'); 
            $table->decimal('rating', 5, 2)->nullable(); 
            $table->string('exam_date')->nullable(); 
            $table->string('exam_place')->nullable(); 
            $table->string('license_number')->nullable(); 
            $table->string('license_validity')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_civil_service_eligibilities');
    }
};
