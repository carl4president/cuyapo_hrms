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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('position_name');
            $table->foreignId('department_id')->constrained('departments');
            $table->timestamps();
        });
        DB::table('positions')->insert([
            // Office of the Municipal Mayor
            ['position_name' => 'Municipal Mayor', 'department_id' => 1],
            ['position_name' => 'Mayor\'s Executive Assistant', 'department_id' => 1],
            ['position_name' => 'Special Assistant to the Mayor', 'department_id' => 1],
            
            // Office of the Municipal Administrator
            ['position_name' => 'Municipal Administrator', 'department_id' => 2],
            ['position_name' => 'Assistant Municipal Administrator', 'department_id' => 2],
        
            // Municipal Assessor's Office
            ['position_name' => 'Municipal Assessor', 'department_id' => 3],
            ['position_name' => 'Senior Assessor', 'department_id' => 3],
            ['position_name' => 'Assistant Assessor', 'department_id' => 3],
            
            // Municipal Budget Office
            ['position_name' => 'Municipal Budget Officer', 'department_id' => 4],
            ['position_name' => 'Budget Officer Assistant', 'department_id' => 4],
        
            // Municipal Agriculturist's Office
            ['position_name' => 'Municipal Agriculturist', 'department_id' => 5],
            ['position_name' => 'Agricultural Technician', 'department_id' => 5],
            ['position_name' => 'Farm Advisor', 'department_id' => 5],
        
            // Municipal Engineer's Office
            ['position_name' => 'Municipal Engineer', 'department_id' => 6],
            ['position_name' => 'Assistant Municipal Engineer', 'department_id' => 6],
            ['position_name' => 'Civil Engineer', 'department_id' => 6],
        
            // General Services Office
            ['position_name' => 'General Services Officer', 'department_id' => 7],
            ['position_name' => 'Administrative Assistant', 'department_id' => 7],
        
            // Human Resources Management Office
            ['position_name' => 'Human Resources Management Officer', 'department_id' => 8],
            ['position_name' => 'HR Assistant', 'department_id' => 8],
        
            // Municipal Civil Registrar
            ['position_name' => 'Municipal Civil Registrar', 'department_id' => 9],
            ['position_name' => 'Assistant Municipal Civil Registrar', 'department_id' => 9],
        
            // Market Enterprise
            ['position_name' => 'Market Enterprise Supervisor', 'department_id' => 10],
            ['position_name' => 'Market Assistant', 'department_id' => 10],
        
            // Disaster Risk Reduction and Management Office
            ['position_name' => 'Disaster Risk Reduction and Management Officer', 'department_id' => 11],
            ['position_name' => 'Disaster Management Specialist', 'department_id' => 11],
            ['position_name' => 'Rescue Team Leader', 'department_id' => 11],
        
            // Municipal Treasurer's Office
            ['position_name' => 'Municipal Treasurer', 'department_id' => 12],
            ['position_name' => 'Assistant Municipal Treasurer', 'department_id' => 12],
        
            // Municipal Health Office
            ['position_name' => 'Municipal Health Officer', 'department_id' => 13],
            ['position_name' => 'Health Assistant', 'department_id' => 13],
            ['position_name' => 'Medical Officer', 'department_id' => 13],
        
            // Planning and Development Office
            ['position_name' => 'Planning and Development Coordinator', 'department_id' => 14],
            ['position_name' => 'Planning Officer', 'department_id' => 14],
        
            // Social Welfare and Development Office
            ['position_name' => 'Social Welfare and Development Officer', 'department_id' => 15],
            ['position_name' => 'Social Worker', 'department_id' => 15],
            ['position_name' => 'Assistant Social Worker', 'department_id' => 15],
        
            // Municipal Tourism Office
            ['position_name' => 'Municipal Tourism Officer', 'department_id' => 16],
            ['position_name' => 'Tourism Assistant', 'department_id' => 16],
        
            // Environment and Natural Resources Office
            ['position_name' => 'Environment and Natural Resources Officer', 'department_id' => 17],
            ['position_name' => 'Environmental Officer', 'department_id' => 17],
            ['position_name' => 'Natural Resources Assistant', 'department_id' => 17],
        
            // Rural Health Unit
            ['position_name' => 'Rural Health Physician', 'department_id' => 18],
            ['position_name' => 'Nurse', 'department_id' => 18],
            ['position_name' => 'Midwife', 'department_id' => 18],
        
            // Municipal Accounting Office
            ['position_name' => 'Municipal Accountant', 'department_id' => 19],
            ['position_name' => 'Accounting Assistant', 'department_id' => 19],
            ['position_name' => 'Cashier', 'department_id' => 19],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
