<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breadcrumb extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'href',
    ];

    public function parent()
    {
        return $this->belongsTo(Breadcrumb::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Breadcrumb::class, 'parent_id')->with('children');
    }

    public function ancestors()
    {
        $breadcrumbs = collect([]);
        $breadcrumb = $this;

        while ($breadcrumb && $breadcrumb->parent) {
            $breadcrumbs->prepend($breadcrumb->parent);
            $breadcrumb = $breadcrumb->parent;
        }

        return $breadcrumbs;
    }
}
