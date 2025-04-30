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
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id');               // Staff ID
            $table->string('leave_type');             // Type of leave (Vacation, Sick, etc.)
            $table->string('total_leave_days', 15, 6); // Total leave days available
            $table->string('used_leave_days', 15, 6); // Leave days already used
            $table->longText('remaining_leave_days')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
