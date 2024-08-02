<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'house',
        'street',
        'city',
        'district',
        'country',
        'postal_code',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
