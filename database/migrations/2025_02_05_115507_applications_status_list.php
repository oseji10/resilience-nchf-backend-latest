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
        Schema::create('application_status_list', function (Blueprint $table) {
            $table->id('statusId');
            $table->string('label')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            // $table->enum('status', ['application_in_progress', 'pending_doctor_review', 'doctor_approved', 'social_worker_approved', 'tumour_board_approved', 'cmd_approved', 'final_approval', 'rejected', 'disabled', 'deceased', 'cured',])->default('application_in_progress')->nullable();
            
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
