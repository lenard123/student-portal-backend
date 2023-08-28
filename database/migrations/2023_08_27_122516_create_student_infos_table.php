<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Student ID
Birthday
BirthPlace
Civil Status
Religion
Nationality
Gender

     */
    public function up(): void
    {
        Schema::create('student_infos', function (Blueprint $table) {
            $table->foreignId('id')->primary()->constrained('users');
            $table->string('student_id')->unique();
            $table->date('birthday')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_infos');
    }
};
