<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->char('patient_firstname', 20);
            $table->char('patient_lastname', 100);
            $table->char('patient_cpf', 11)->unique();
            $table->char('patient_phone',17);
            $table->char('patient_email', 120);
            $table->integer('patient_gender');
            $table->date('patient_birth_date');
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
        Schema::dropIfExists('patients');
    }
}
