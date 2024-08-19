<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveType;
use App\Models\User;

class AppliedLeave extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'approved_by',
        'type',
        'date',
        'approved',
        'reason',
    ];

    public function type()
    {
        return $this->belongsTo(LeaveType::class, 'type');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
