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
        Schema::create('social_welfare_assessment', function (Blueprint $table) {
            $table->id('assessmentId');
            $table->unsignedBigInteger('patientUserId')->nullable();
            $table->string('appearance')->nullable();
            $table->string('bmi')->nullable();
            $table->text('commentOnHome')->nullable();
            $table->text('commentOnEnvironment')->nullable();
            $table->text('commentOnFamily')->nullable();
            $table->text('generalComment')->nullable();
            $table->unsignedBigInteger('parent1Education')->nullable();
            $table->unsignedBigInteger('parent1Occupation')->nullable();
            $table->unsignedBigInteger('parent2Education')->nullable();
            $table->unsignedBigInteger('parent2Occupation')->nullable();
            $table->boolean('useSecondParent')->default(false);
            $table->string('sesResult')->nullable();
          

            $table->string('status')->nullable();
            
            $table->unsignedBigInteger('reviewerId')->nullable();

            $table->foreign('patientUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewerId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parent1Education')->references('qualificationId')->on('social_welfare_ses_qualification')->onDelete('cascade');
            $table->foreign('parent1Occupation')->references('occupationId')->on('social_welfare_ses_occupation')->onDelete('cascade');
            $table->foreign('parent2Education')->references('qualificationId')->on('social_welfare_ses_qualification')->onDelete('cascade');
            $table->foreign('parent2Occupation')->references('occupationId')->on('social_welfare_ses_occupation')->onDelete('cascade');
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
