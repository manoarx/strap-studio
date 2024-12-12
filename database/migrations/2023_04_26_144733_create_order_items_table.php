<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->string('product_type')->nullable();
            $table->string('booked_date')->nullable();
            $table->string('booked_stime')->nullable();
            $table->string('booked_etime')->nullable();
            $table->integer('option_id')->nullable();
            $table->integer('addon_id')->nullable();
            $table->integer('addon_qty')->nullable();
            $table->float('digital_price',8,2)->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('qty');
            $table->float('price',8,2); 
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
        Schema::dropIfExists('order_items');
    }
};
