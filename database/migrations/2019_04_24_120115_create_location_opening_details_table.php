<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationOpeningDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('location_opening_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id');
            $table->integer('day');
            $table->time('open_time');
            $table->time('closesing_time');
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
        Schema::dropIfExists('location_opening_details');
    }
}
