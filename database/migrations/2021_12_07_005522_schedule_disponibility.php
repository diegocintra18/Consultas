<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScheduleDisponibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_disponibility', function (Blueprint $table) {
            $table->id('schedule_disponibility_id');
            $table->integer('schedule_sunday');
            $table->integer('schedule_monday');
            $table->integer('schedule_tuesday');
            $table->integer('schedule_wednesday');
            $table->integer('schedule_thursday');
            $table->integer('schedule_friday');
            $table->integer('schedule_saturday');
            $table->foreignId('schedule_settings_id');
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
        Schema::dropIfExists('schedule_settings');

        Schema::table('schedule_settings', function (Blueprint $table) {
            $table->foreignId('schedule_settings_id')
            ->onDelete('cascade');
        });
    }
}
