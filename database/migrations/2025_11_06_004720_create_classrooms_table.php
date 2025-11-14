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
       Schema::create('classrooms', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // contoh: X RPL 1
    $table->foreignId('academic_year_id')->constrained();
    $table->foreignId('teacher_id')->nullable()->constrained('users'); // Wali kelas adalah user dengan role 'wali_kelas'
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
};
