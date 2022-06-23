<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration
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
            $table->string('name');
            $table->foreignId('age_id')->constrained();
            $table->foreignId('class_id')->constrained('classes');
            $table->foreignId('gender_id')->constrained('genders');
            $table->string('address');
            $table->foreignId('race_id')->constrained();
            $table->foreignId('religion_id')->constrained();
            $table->string('picture')->nullable();
            $table->foreignId('parent_id')->constrained('users');
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
}
