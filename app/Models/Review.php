<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'reviewID';
    protected $fillable = ['reservationID','reviewID','roomID', 'rate', 'comment'];

    public function room()
{
    return $this->belongsTo(Room::class, 'roomID');
}

}
