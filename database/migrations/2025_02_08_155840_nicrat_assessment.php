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
        Schema::create('nicrat_assessment', function (Blueprint $table) {
            $table->id('assessmentId');
            $table->unsignedBigInteger('patientUserId')->nullable();
            
            $table->text('comments')->nullable();
            $table->string('status')->nullable();
            
            $table->unsignedBigInteger('reviewerId')->nullable();

            $table->foreign('patientUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewerId')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
