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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id('doctorId');
            $table->string('doctorName')->nullable();
            $table->string('title')->nullable();
            $table->string('department')->nullable();
            $table->enum('status', ['active', 'disabled'])->default('active')->nullable();
            $table->unsignedBigInteger('userId')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
