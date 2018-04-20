<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubfleetTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subfleets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('airline_id')->nullable();
            $table->string('name', 50);
            $table->string('type', 50);
            $table->unsignedTinyInteger('fuel_type')->nullable();
            $table->unsignedDecimal('cargo_capacity')->nullable();
            $table->unsignedDecimal('fuel_capacity')->nullable();
            $table->unsignedDecimal('gross_weight')->nullable();
            $table->timestamps();
        });

        Schema::create('subfleet_expenses', function(Blueprint $table) {
            $table->unsignedBigInteger('subfleet_id');
            $table->string('name', 50);
            $table->unsignedDecimal('cost');

            $table->primary(['subfleet_id', 'name']);
        });

        Schema::create('subfleet_fare', function (Blueprint $table) {
            $table->unsignedInteger('subfleet_id');
            $table->unsignedInteger('fare_id');
            $table->unsignedDecimal('price')->nullable();
            $table->unsignedDecimal('cost')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->timestamps();

            $table->primary(['subfleet_id', 'fare_id']);
            $table->index(['fare_id', 'subfleet_id']);
        });

        Schema::create('subfleet_flight', function(Blueprint $table) {
            $table->unsignedInteger('subfleet_id');
            $table->string('flight_id', 12);

            $table->primary(['subfleet_id', 'flight_id']);
            $table->index(['flight_id', 'subfleet_id']);
        });

        Schema::create('subfleet_rank', function(Blueprint $table) {
            $table->unsignedInteger('rank_id');
            $table->unsignedInteger('subfleet_id');
            $table->unsignedDecimal('acars_pay')->nullable();
            $table->unsignedDecimal('manual_pay')->nullable();

            $table->primary(['rank_id', 'subfleet_id']);
            $table->index(['subfleet_id', 'rank_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subfleets');
        Schema::dropIfExists('subfleet_expenses');
        Schema::dropIfExists('subfleet_fare');
        Schema::dropIfExists('subfleet_flight');
        Schema::dropIfExists('subfleet_rank');
    }
}
