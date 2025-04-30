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
        Schema::create('applicant_government_ids', function (Blueprint $table) {
            $table->id();
            $table->string('app_id'); 
            $table->foreign('app_id')->references('app_id')->on('applicants')->onDelete('cascade');
            $table->string('agency_employee_no')->nullable();
            $table->string('sss_no')->nullable();
            $table->string('gsis_id_no')->nullable();
            $table->string('pagibig_no')->nullable();
            $table->string('philhealth_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_government_ids');
    }
};
