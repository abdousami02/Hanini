<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->double('price',20,3)->unsigned()->default(0.00);
            $table->double('tax',10,3)->default(0.00);
            $table->double('discount',10,3)->default(0.00);
            $table->string('coupon_discount')->nullable()->comment('will be json data {"coupon_code" : "BLACK5", "discount" : 5}');
            $table->string('shipping_cost')->nullable()->comment('will be json data {"type" : "flat","depend_on_quantity" : true, "per_cost" : 10}');
            $table->integer('qte')->default(1);
            $table->string('product_referral_code')->nullable();
            // $table->string('variation')->nullable();
            // $table->boolean('is_refundable')->default(0)->comment('1 => can be refunded');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
