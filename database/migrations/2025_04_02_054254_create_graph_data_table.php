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
        Schema::create('graph_data', function (Blueprint $table) {
            $table->id();
            $table->string('graph_type'); // Store the graph type (e.g., bar, line, etc.)
            $table->string('department_filter_column')->nullable();
            $table->string('filter_column')->nullable(); // Store the filter column used for the graph
            $table->json('data')->nullable(); // Store graph data (e.g., labels and values)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graph_data');
    }
};
