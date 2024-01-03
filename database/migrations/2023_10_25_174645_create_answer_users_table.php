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
        Schema::create('answer_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('result_id');
            $table->foreignId('user_id');
            $table->foreignId('question_id')->nullable();
            $table->foreignId('answer_id')->nullable();
            $table->boolean('correct');
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_users');
    }
};
