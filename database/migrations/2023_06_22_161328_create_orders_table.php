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
            $table->uuid();
            $table->string('code');

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('menu_item_id')->constrained('menu_items')->cascadeOnDelete();
            $table->integer('quantity');
            $table->string('location');
            $table->string('delivery_status')->default('pending'); // ['pending', 'on_way', 'delivered']
            // set default as paid since we're not implementing payment feature
            $table->string('payment_status')->default('paid');
            $table->string('payment_channel')->default('momo');
            $table->float('price');

            $table->string('gps')->nullable();
            $table->string('mobile_number');

            $table->boolean('is_active')->default(true);
            $table->foreignId('added_by_id')->nullable();
            $table->softDeletes();
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
