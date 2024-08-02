<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'position',
    ];

    // Define the relationship with the Department model
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
