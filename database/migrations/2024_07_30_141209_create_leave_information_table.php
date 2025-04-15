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
        Schema::create('leave_information', function (Blueprint $table) {
            $table->id();
            $table->longText('staff_id');
            $table->string('leave_type'); 
            $table->decimal('leave_days', 8, 3)->unsigned();
            $table->year('year_leave'); 
            $table->timestamps();
        });       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_information');
    }
};
