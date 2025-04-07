<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name_type_job')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
        DB::table('type_jobs')->insert([
            ['name_type_job' => 'Full Time', 'color' => 'info'],      // Bootstrap color 'info'
            ['name_type_job' => 'Part Time', 'color' => 'success'],    // Bootstrap color 'success'
            ['name_type_job' => 'Internship', 'color' => 'danger'],    // Bootstrap color 'danger'
            ['name_type_job' => 'Temporary', 'color' => 'warning'],    // Bootstrap color 'warning'
            ['name_type_job' => 'Remote', 'color' => 'dark'],          // Bootstrap color 'dark'
            ['name_type_job' => 'Others', 'color' => 'secondary'],     // Bootstrap color 'secondary'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_jobs');
    }
};
