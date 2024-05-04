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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_list_id')->nullable()->constrained('task_lists')->cascadeOnDelete()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->enum('status', ['pending', 'in progress','completed', 'incomplete'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
