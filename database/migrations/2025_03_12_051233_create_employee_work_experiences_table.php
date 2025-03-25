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
        Schema::create('employee_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id'); 
            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');
            
            $table->string('from_date')->nullable(); 
            $table->string('to_date')->nullable(); 
            $table->string('position_title')->nullable();
            $table->string('department_agency_office_company')->nullable();
            $table->decimal('monthly_salary', 10, 2)->nullable();
            $table->string('salary_grade')->nullable()->nullable();
            $table->string('status_of_appointment')->nullable();
            $table->boolean('govt_service')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_work_experiences');
    }
};
