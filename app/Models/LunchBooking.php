<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LunchBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
