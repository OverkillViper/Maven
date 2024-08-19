<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Department;
use App\Models\Address;
use App\Models\Designation;
use Carbon\Carbon;
class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'avatar',
        'user_id',
        'employee_id',
        'department_id',
        'designation_id',
        'servicetype',
        'salary',
        'job_location',
        'joined_at',
        'permanent_at',
        'date_of_birth',
        'marital_status',
        'gender',
        'servicetype',
        'blood_group',
        'contact',
        'nid',
        'passport',
        'driving_license',
        'religion',
        'nationality',
        'father_name',
        'mother_name',
        'spouse_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function presentAddress()
    {
        return $this->hasOne(Address::class)->where('address_type', 'Present');
    }

    public function permanentAddress()
    {
        return $this->hasOne(Address::class)->where('address_type', 'Permanent');
    }

    public function experience()
    {
        if ($this->joined_at) {
            $joinedAt = Carbon::parse($this->joined_at);
            $now = Carbon::now();

            $years = (int) $joinedAt->diffInYears($now);
            $months = $joinedAt->diffInMonths($now) % 12;

            return [
                'years' => $years,
                'months' => $months,
            ];
        }

        return [
            'years' => 0,
            'months' => 0,
        ];
    }
}
