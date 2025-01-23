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
        Schema::create('task_dependencies_pivot', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('task_id')->constrained('tasks')->onDelete('restrict');
            $table->foreignId('dependency_id')->constrained('tasks')->onDelete('restrict');
            $table->unique(['task_id', 'dependency_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_dependencies_pivot');
    }
};
