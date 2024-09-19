<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grade_divisions', function (Blueprint $table) {
            $table->id();
            $table->enum('division', [
                'Nursery-UKG',
                '1-4',
                '5-8',
                '9-10',
                '11-12',
                'Nursery-4',
                'Nursery-8',
                'Nursery-10',
                'Nursery-12',
                '1-8',
                '1-10',
                '1-12',
                '5-10',
                '5-12',
                '9-12'
            ])->default('Nursery-UKG');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
