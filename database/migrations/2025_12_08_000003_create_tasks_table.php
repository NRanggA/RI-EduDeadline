<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul tugas
            $table->text('description')->nullable(); // Deskripsi lengkap
            $table->unsignedBigInteger('course_id'); // Mata kuliah terkait
            $table->dateTime('deadline'); // Deadline tugas
            $table->enum('priority', ['rendah', 'normal', 'urgent'])->default('normal'); // Prioritas
            $table->string('attachment_path')->nullable(); // Path file attachment
            $table->enum('status', ['pending', 'in_progress', 'completed', 'overdue'])->default('pending'); // Status
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->unsignedBigInteger('created_by')->nullable(); // User yang membuat (dosen)
            $table->timestamps();

            // Foreign keys
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onNullableDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
