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
        Schema::create('employee_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id'); 
            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');
            $table->text('residential_address');
            $table->string('residential_zip', 10);
            $table->text('permanent_address');
            $table->string('permanent_zip', 10);
            $table->string('phone_number')->nullable();
            $table->string('mobile_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_contacts');
    }
};
