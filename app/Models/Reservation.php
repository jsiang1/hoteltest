<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['roomID', 'customerID', 'checkInDate', 'checkOutDate', 'reservedRoomNumber', 'totalPrice'];
    
    public function room()
    {
        return $this->belongsTo(Room::class, 'roomID');
    }
}
