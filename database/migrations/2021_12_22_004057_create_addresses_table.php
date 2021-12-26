<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->char('adress_name', 200);
            $table->integer('address_number');
            $table->integer('address_zipcode');
            $table->char('address_complement', 100);
            $table->char('address_district', 50);
            $table->char('address_city', 30);
            $table->char('address_uf', 2);
            $table->timestamps();
        });

        Schema::create('address_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patients_id')->constrained('patients');
            $table->foreignId('addresses_id')->constrained('addresses');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_patients');
        Schema::dropIfExists('addresses');
    }
}
