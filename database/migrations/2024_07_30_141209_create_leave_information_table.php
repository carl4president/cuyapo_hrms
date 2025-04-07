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
            $table->string('staff_id'); 
            $table->string('leave_type'); 
            $table->integer('leave_days');
            $table->integer('carried_forward');
            $table->year('year_leave'); 
            $table->timestamps();
        });
        
        DB::table('leave_information')->insert([
            [
                'staff_id'            => 'KH-0002',
                'leave_type'          => 'Medical Leave',
                'leave_days'          => 4,
                'carried_forward'     => 0,
                'year_leave'          => date('Y'),
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'staff_id'            => 'KH-0002',
                'leave_type'          => 'Casual Leave',
                'leave_days'          => 8,
                'carried_forward'     => 0,
                'year_leave'          => date('Y'),
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'staff_id'            => 'KH-0002',
                'leave_type'          => 'Sick Leave',
                'leave_days'          => 5,
                'carried_forward'     => 0,
                'year_leave'          => date('Y'),
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'staff_id'            => 'KH-0002',
                'leave_type'          => 'Annual Leave',
                'leave_days'          => 12,
                'carried_forward'     => 0,

                'year_leave'          => date('Y'),
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'staff_id'            => 'KH-0002',
                'leave_type'          => 'Use Leave',
                'leave_days'          => 9,
                'carried_forward'     => 0,
                'year_leave'          => date('Y'),
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'staff_id'            => 'KH-0002',
                'leave_type'          => 'Remaining Leave',
                'leave_days'          => 18,
                'carried_forward'     => 0,

                'year_leave'          => date('Y'),
                'created_at'          => now(),
                'updated_at'          => now()
            ],
            [
                'staff_id'            => 'KH-0002',
                'leave_type'          => 'Total Leave Balance',
                'leave_days'          => 0,
                'carried_forward'     => 0,
                'year_leave'          => date('Y'),
                'created_at'          => now(),
                'updated_at'          => now()
            ]
        ]);        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_information');
    }
};
