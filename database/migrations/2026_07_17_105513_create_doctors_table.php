<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('medical_id')->unique();
            $table->string('specialty');
            $table->integer('experience_years')->default(0);
            $table->decimal('rating', 3, 1)->default(0.0);
            $table->integer('reviews_count')->default(0);
            $table->string('location')->nullable();
            $table->text('bio')->nullable();
            $table->enum('status', ['active', 'on_leave', 'inactive'])->default('active');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
