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
        Schema::create('attendances', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained();
    $table->date('date');
    $table->time('time_in');
    $table->enum('status', ['hadir', 'sakit', 'izin', 'alpha'])->default('hadir');
    $table->text('notes')->nullable();
    $table->timestamps();

    // Pastikan satu siswa hanya bisa absen sekali per hari
    $table->unique(['student_id', 'date']);
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
