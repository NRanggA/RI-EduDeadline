<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thesis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Mahasiswa yang mengerjakan
            $table->string('title'); // Judul skripsi
            $table->text('description')->nullable(); // Deskripsi skripsi
            $table->unsignedBigInteger('advisor_id')->nullable(); // Pembimbing utama
            $table->unsignedBigInteger('co_advisor_id')->nullable(); // Pembimbing kedua (optional)
            $table->dateTime('defense_deadline')->nullable(); // Deadline sidang
            $table->enum('status', ['planning', 'in_progress', 'submitted', 'defended', 'completed'])->default('planning');
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('advisor_id')->references('id')->on('users')->onNullableDelete();
            $table->foreign('co_advisor_id')->references('id')->on('users')->onNullableDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thesis');
    }
};
