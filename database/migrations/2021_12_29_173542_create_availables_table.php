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
            $table->time('available_start');
            $table->time('available_end');
            $table->foreignId('schedule_settings_id')->constrained('schedule_settings');
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
    }
}
