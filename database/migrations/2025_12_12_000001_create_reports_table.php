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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecturer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->dateTime('period_start');
            $table->dateTime('period_end');
            $table->integer('total_tasks')->default(0);
            $table->integer('completed_on_time')->default(0);
            $table->integer('completed_late')->default(0);
            $table->integer('not_submitted')->default(0);
            $table->decimal('accuracy_rate', 5, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Add indexes for faster queries
            $table->index('lecturer_id');
            $table->index('course_id');
            $table->index('period_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
