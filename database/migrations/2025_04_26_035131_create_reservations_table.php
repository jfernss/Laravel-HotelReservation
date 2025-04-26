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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('contact_number', 20);
            $table->string('room_type', 50);
            $table->string('room_capacity', 50);
            $table->string('payment_type', 50);
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('num_days');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('additional_charge', 10, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->decimal('total_bill', 10, 2);
            $table->timestamp('reservation_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
