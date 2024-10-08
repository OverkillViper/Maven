<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveType;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'user_id',
        'allocation',
    ];

    public function type()
    {
        return $this->belongsTo(LeaveType::class, 'type');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
