<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // id as primary key and auto-incrementing
            $table->string('fullname');
            $table->string('grade');
            $table->date('enrollment_date');
            $table->string('status');
            $table->foreignId('branch_id')->constrained('branches'); // Foreign key referencing the branches table
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}

