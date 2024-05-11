<?php
/**
 * @author Whelan Yap Boon Hong
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservationID',
        'date',
        'paymentMethod',
        'cardholderName',
        'cardNumber',
        'cardExp',
        'cvv',
        'billingAddress',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}

