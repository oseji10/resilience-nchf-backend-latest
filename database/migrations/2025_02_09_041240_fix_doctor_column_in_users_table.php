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
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropForeign(['doctor']); // Drop foreign key first
        //     $table->dropColumn('doctor'); // Then drop the column
        // });
        

        // Schema::table('patients', function (Blueprint $table) {
        //     $table->unsignedBigInteger('doctorId')->nullable();
        //     $table->foreign('doctorId')->references('id')->on('users')->onDelete('cascade');
        // });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
