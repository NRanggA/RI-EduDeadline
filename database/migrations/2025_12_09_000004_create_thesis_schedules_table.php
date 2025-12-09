<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thesis_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thesis_id'); // Skripsi yang dijadwalkan
            $table->dateTime('defense_date'); // Tanggal sidang
            $table->time('defense_time'); // Jam sidang
            $table->string('location'); // Lokasi sidang
            $table->string('room')->nullable(); // Ruangan sidang
            $table->unsignedBigInteger('examiner_1_id')->nullable(); // Penguji 1
            $table->unsignedBigInteger('examiner_2_id')->nullable(); // Penguji 2
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'postponed'])->default('scheduled');
            $table->timestamps();

            // Foreign keys
            $table->foreign('thesis_id')->references('id')->on('thesis')->onDelete('cascade');
            $table->foreign('examiner_1_id')->references('id')->on('users')->onNullableDelete();
            $table->foreign('examiner_2_id')->references('id')->on('users')->onNullableDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thesis_schedules');
    }
};
