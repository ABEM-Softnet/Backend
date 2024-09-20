<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Branch;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->unsignedTinyInteger('grade');
            $table->char('section', 1);
            $table->decimal('score', 5, 2); // Score out of 100
            $table->unsignedSmallInteger('total_days_present');
            $table->unsignedSmallInteger('total_days_absent');
            $table->unsignedSmallInteger('days_present_this_month');
            $table->unsignedTinyInteger('days_present_this_week');
            $table->boolean('is_newcomer');
            $table->foreignIdFor(Branch::class)->constrained()->onDelete('cascade'); // Foreign key with constraint
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
