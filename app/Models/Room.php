<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $primaryKey = 'roomID';
    protected $fillable = ['roomID', 'reviewID', 'pricePerNight', 'roomType'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'roomID');
    }

    public function reviews()
{
    return $this->hasMany(Review::class, 'roomID');
}
}
