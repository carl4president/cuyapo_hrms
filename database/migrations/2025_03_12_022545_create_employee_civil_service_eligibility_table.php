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
        Schema::create('employee_civil_service_eligibility', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id'); 
            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');

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
        Schema::dropIfExists('civil_service_eligibility');
    }
};
