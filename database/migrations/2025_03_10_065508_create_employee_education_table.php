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
        Schema::create('employee_education', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id'); 
            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');
    
            $table->string('education_level'); // Elementary, Secondary, etc.
            $table->string('degree')->nullable();
            $table->string('school_name');
            $table->integer('year_from')->nullable(); // Changed to integer(4)
            $table->integer('year_to')->nullable();   // Changed to integer(4)
            $table->string('highest_units_earned')->nullable();
            $table->integer('year_graduated')->nullable(); // Changed to integer(4)
            $table->string('scholarship_honors')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_education');
    }
};
