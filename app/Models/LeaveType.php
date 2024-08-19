<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Leave;
use App\Models\AppliedLeave;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'type');
    }

    public function appliedLeaves()
    {
        return $this->hasMany(AppliedLeave::class, 'type');
    }
}
