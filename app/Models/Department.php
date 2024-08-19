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
        return $this->belongsTo(Department::class, 'parent_id')->with('parent');
    }

    public function children() {
        return $this->hasMany(Department::class, 'parent_id')->with('children');
    }

    public function hasChild() {
        return $this->children()->count() > 0;
    }

    public function ancestors()
    {
        $ancestors = collect([]);
        $department = $this;

        while ($department && $department->parent) {
            $ancestors->push($department->parent);
            $department = $department->parent;
        }

        return $ancestors;
    }
}
