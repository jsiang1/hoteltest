<?php
/**
 * @author Lee Kong Hang
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'reservationID';
    protected $fillable = ['reservationID','roomID', 'customerID', 'checkInDate', 'checkOutDate', 'reservedRoomNumber', 'totalPrice','service'];
    
    public function room()
    {
        return $this->belongsTo(Room::class, 'roomID');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function reviewExists()
    {
        return Review::where('reservationID', $this->reservationID)->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'customerID','id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
