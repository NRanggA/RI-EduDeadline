<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thesis_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thesis_submission_id'); // Submission yang diberi feedback
            $table->unsignedBigInteger('advisor_id'); // Dosen yang memberi feedback
            $table->text('feedback'); // Isi feedback
            $table->enum('type', ['general', 'specific'])->default('general'); // Tipe feedback
            $table->integer('line_number')->nullable(); // Nomor baris (jika specific)
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('is_resolved')->default(false); // Status resolusi
            $table->timestamps();

            // Foreign keys
            $table->foreign('thesis_submission_id')->references('id')->on('thesis_submissions')->onDelete('cascade');
            $table->foreign('advisor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thesis_feedback');
    }
};
