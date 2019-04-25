<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePodPriceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('pod_price_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('min_range_limit');
            $table->integer('max_range_limit');
            $table->integer('price');
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
        Schema::dropIfExists('pod_price_details');
    }
}
