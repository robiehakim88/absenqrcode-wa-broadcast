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
        Schema::create('students', function (Blueprint $table) {
    $table->id();
    $table->string('nis')->unique(); // Nomor Induk Siswa
    $table->string('name');
    $table->foreignId('classroom_id')->constrained();
    $table->string('parent_phone'); // Nomor HP orang tua untuk WhatsApp
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
        Schema::dropIfExists('students');
    }
};
