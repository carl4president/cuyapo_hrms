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
        Schema::create('applicant_voluntary_works', function (Blueprint $table) {
            $table->id();
            $table->string('app_id'); 
            $table->foreign('app_id')->references('app_id')->on('applicants')->onDelete('cascade');

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
        Schema::dropIfExists('applicant_voluntary_works');
    }
};
