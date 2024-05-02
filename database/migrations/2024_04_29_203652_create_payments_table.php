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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('paymentID');
            $table->unsignedBigInteger('reservationID');
            $table->foreign('reservationID')->references('reservationID')->on('reservations')->onDelete('cascade'); // Assuming roomID is a foreign key referencing the rooms table
            $table->date('date');
            $table->string('paymentMethod');
            $table->string('cardholderName');
            $table->string('cardNumber');
            $table->string('cardExp');
            $table->integer('cvv');
            $table->string('billingAddress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
