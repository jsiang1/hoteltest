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
            $table->id('reservationID');
            $table->unsignedBigInteger('roomID');
            $table->foreign('roomID')->references('roomID')->on('rooms')->onDelete('cascade'); // Assuming roomID is a foreign key referencing the rooms table

            $table->unsignedBigInteger('customerID');
            $table->foreign('customerID')->references('id')->on('users')->onDelete('cascade'); // Assuming customerID is a foreign key referencing the users table

            $table->dateTime('checkInDate');
            $table->dateTime('checkOutDate');
            $table->unsignedBigInteger('reservedRoomNumber'); // Change the column type to unsignedBigInteger
            $table->decimal('totalPrice', 8, 2);
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
