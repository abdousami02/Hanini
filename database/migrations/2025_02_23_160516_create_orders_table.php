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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id')->unsigned()->nullable()->comment('seller user id');
            $table->bigInteger('user_id')->unsigned()->nullable()->comment('customer');
            $table->string('code')->nullable();
            // $table->longText('billing_address')->nullable();
            $table->longText('shipping_address')->nullable();
            $table->string('status')->default('pending');
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->longText('payment_details')->nullable();
            $table->double('sub_total',20,3)->default(0.00);
            $table->double('discount',10,3)->default(0.00);
            $table->double('coupon_discount',10,3)->default(0.00);
            $table->double('total_tax',10,3)->default(0.00);
            $table->double('total_amount',20,3)->nullable()->comment('sub_total,tax,discounts');
            $table->double('shipping_cost',10,3)->default(0.00);
            $table->double('total_payable',20,3)->default(0.00);
            $table->timestamp('date')->nullable();
            $table->tinyInteger('viewed')->default(0);
            $table->boolean('is_mailed')->default(false);
            $table->string('shipping_method')->nullable();
            
            // $table->string('trx_id');
            // $table->string('tax_method')->default('{"vat_tax_type" : "","tax_type" : "" }')
            // $table->tinyInteger('delivery_viewed')->default(0);
            // $table->tinyInteger('payment_status_viewed')->default(0);
            // $table->tinyInteger('commission_calculated')->default(0);
            // $table->string('is_cancelled')->default(0)->nullable();
            // $table->string('is_deleted')->default(0)->nullable();
            
            // $table->string('offline_method_id')->nullable();
            // $table->string('offline_method_file')->nullable();
            // $table->boolean('status')->default(false);
            // $table->unsignedBigInteger('pickup_hub_id')->nullable();
            // //delivery hero
            // $table->bigInteger('delivery_hero_id')->unsigned()->nullable()->comment('from delivery hero table');
            // $table->tinyInteger('cancel_request')->default(0);
            // $table->timestamp('cancel_request_at')->nullable();
            // $table->timestamp('delivery_hero_assign_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
