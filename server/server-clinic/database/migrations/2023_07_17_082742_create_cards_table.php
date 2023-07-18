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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Client_id');
            $table->foreign('Client_id')->references('id')->on('users');
            $table->unsignedBigInteger('Doctor_id');
            $table->foreign('Doctor_id')->references('id')->on('users');
            $table->string('Symptoms',250)->nullable();
            $table->date('Visit_date');
            $table->time('Visit_time');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
