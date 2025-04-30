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
        Schema::create('applicant_education', function (Blueprint $table) {
            $table->id();
            $table->string('app_id'); 
            $table->foreign('app_id')->references('app_id')->on('applicants')->onDelete('cascade');
    
            $table->string('education_level'); // Elementary, Secondary, etc.
            $table->string('degree')->nullable();
            $table->string('school_name');
            $table->string('year_from')->nullable(); // Changed to integer(4)
            $table->string('year_to')->nullable();   // Changed to integer(4)
            $table->string('highest_units_earned')->nullable();
            $table->string('year_graduated')->nullable(); // Changed to integer(4)
            $table->string('scholarship_honors')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_education');
    }
};
