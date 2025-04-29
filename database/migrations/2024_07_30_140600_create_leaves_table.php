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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('leave_type')->nullable();;
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();
            $table->longText('leave_date')->nullable();
            $table->longText('leave_day')->nullable();
            $table->string('number_of_day')->nullable();
            $table->string('reason')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('status')->nullable();

            $table->string('commutation')->nullable();

            $table->string('vacation_location')->nullable();  // For vacation location (Philippines/Abroad)
            $table->string('abroad_specify')->nullable();    // For specifying country if "Abroad"
            $table->string('sick_location')->nullable();     // For sick leave location (In Hospital/Out Patient)
            $table->string('illness_specify')->nullable();   // For specifying illness
            $table->string('women_illness')->nullable();     // For special leave women illness
            $table->text('study_reason')->nullable();        // For study leave reasons
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
