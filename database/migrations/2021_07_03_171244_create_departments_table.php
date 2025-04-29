<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department')->nullable();
            $table->timestamps();
        });
        DB::table('departments')->insert([
            ['department' => 'Office of the Municipal Mayor'],
            ['department' => 'Office of the Municipal Administrator'],
            ['department' => 'Municipal Assessor\'s Office'],
            ['department' => 'Municipal Budget Office'],
            ['department' => 'Municipal Agriculturist\'s Office'],
            ['department' => 'Municipal Engineer\'s Office'],
            ['department' => 'General Services Office'],
            ['department' => 'Human Resources Management Office'],
            ['department' => 'Municipal Civil Registrar'],
            ['department' => 'Market Enterprise'],
            ['department' => 'Disaster Risk Reduction and Management Office'],
            ['department' => 'Municipal Treasurer\'s Office'],
            ['department' => 'Municipal Health Office'],
            ['department' => 'Planning and Development Office'],
            ['department' => 'Social Welfare and Development Office'],
            ['department' => 'Municipal Tourism Office'],
            ['department' => 'Environment and Natural Resources Office'],
            ['department' => 'Rural Health Unit'],
            ['department' => 'Municipal Accounting Office'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
