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
        Schema::create('patient_application_review', function (Blueprint $table) {
            $table->id('reviewId');
            $table->unsignedBigInteger('patientUserId')->nullable();
            $table->unsignedBigInteger('reviewerId')->nullable();
            $table->unsignedBigInteger('reviewerRole')->nullable();
            $table->unsignedBigInteger('statusId')->nullable();
            // $table->enum('status', ['application_in_progress', 'pending_doctor_review', 'doctor_approved', 'social_worker_approved', 'tumour_board_approved', 'cmd_approved', 'final_approval', 'rejected', 'disabled', 'deceased', 'cured',])->default('application_in_progress')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('patientUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewerId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewerRole')->references('roleId')->on('roles')->onDelete('cascade');
            $table->foreign('statusId')->references('statusId')->on('application_status_list')->onDelete('cascade');
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
