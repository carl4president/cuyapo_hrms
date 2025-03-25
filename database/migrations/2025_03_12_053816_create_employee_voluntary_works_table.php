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
        Schema::create('employee_voluntary_works', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id'); 
            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');

            $table->string('organization_name')->nullable(); 
            $table->string('from_date')->nullable();  
            $table->string('to_date')->nullable(); 
            $table->integer('number_of_hours')->nullable();
            $table->string('position_nature_of_work')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_voluntary_works');
    }
};
