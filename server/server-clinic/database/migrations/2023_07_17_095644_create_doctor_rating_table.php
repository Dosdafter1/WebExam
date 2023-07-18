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
        Schema::create('doctor_rating', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Client_id');
            $table->foreign('Client_id')->references('id')->on('users');
            $table->unsignedBigInteger('Doctor_id');
            $table->foreign('Doctor_id')->references('id')->on('users');
            $table->integer('Rate')->max(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_rating');
    }
};
