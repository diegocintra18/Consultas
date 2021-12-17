<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_duration_limit');
            $table->integer('schedule_before_break');
            $table->integer('schedule_after_break');
            $table->string('schedule_day_start');
            $table->string('schedule_lunch_start');
            $table->string('schedule_lunch_end');
            $table->string('schedule_day_end');
            $table->foreignId('user_id')->constrained('users');
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

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('user_id')
            ->onDelete('cascade');
        });
    }
}
