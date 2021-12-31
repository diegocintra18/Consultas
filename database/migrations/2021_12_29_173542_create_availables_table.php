<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availables', function (Blueprint $table) {
            $table->id();
            $table->string('available_hour');
            $table->foreignId('schedule_settings_id')->constrained('schedule_settings');
            $table->timestamps();
        });

        Schema::create('schedules_date', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules');
            $table->foreignId('available_id')->constrained('availables');
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
        Schema::dropIfExists('availables');

        Schema::table('schedule_settings', function (Blueprint $table) {
            $table->foreignId('schedule_settings_id')
            ->onDelete('cascade');
        });

        Schema::dropIfExists('schedules_date');

        Schema::table('schedules', function (Blueprint $table) {
            $table->foreignId('schedule_id')
            ->onDelete('cascade');
        });

        Schema::table('availables', function (Blueprint $table) {
            $table->foreignId('available_id')
            ->onDelete('cascade');
        });
    }
}
