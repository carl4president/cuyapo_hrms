<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->unique()->index(); // Auto-generated Employee ID
            $table->string('name');
            $table->string('email')->unique();
            $table->string('birth_date');
            $table->string('place_of_birth');
            $table->string('height');
            $table->string('weight');
            $table->string('blood_type');
            $table->string('gender');
            $table->string('civil_status');
            $table->string('nationality');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
