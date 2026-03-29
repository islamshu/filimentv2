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
        Schema::drop('order_details');
        Schema::drop('orders');

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('location');
            $table->string('street')->nullable();
            $table->string('home')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->decimal('payment', 10, 2);
            $table->decimal('first_batch', 10, 2);
            $table->string('CardName')->change();
            $table->string('first_batch')->change();
            $table->string('cardNumber')->change();
            $table->string('month')->change();
            $table->string('year')->change();
            $table->string('cvc')->change();
            $table->string('payment_getway')->change();
            $table->string('CashOrBatch')->change();
            $table->string('phone2')->nullable();
            $table->mediumText('note')->nullable();
            $table->string('whatsapp')->nullable();
            $table->timestamps();

            // cardNumber
        });
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->on('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
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
