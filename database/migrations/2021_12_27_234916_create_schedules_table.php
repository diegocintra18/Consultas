<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('schedules_date');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('patient_id')->constrained('patients');
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('user_id')
            ->onDelete('cascade');
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('patient_id')
            ->onDelete('cascade');
        });

    }
}
