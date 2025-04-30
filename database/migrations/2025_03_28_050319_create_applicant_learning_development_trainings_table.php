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
        Schema::create('applicant_learning_development_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('app_id'); 
            $table->foreign('app_id')->references('app_id')->on('applicants')->onDelete('cascade');

            $table->string('title')->nullable(); 
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();
            $table->integer('number_of_hours')->nullable();
            $table->string('type_of_ld')->nullable();
            $table->string('conducted_by')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_learning_development_tranings');
    }
};
