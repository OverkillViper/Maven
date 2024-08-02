<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
    ];

    public function parent() {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Department::class, 'parent_id')->with('children');
    }

    public function hasChild() {
        return $this->children()->count() > 0;
    }
}
