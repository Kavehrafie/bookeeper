<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function codes()
    {
        return $this->belongsToMany(Code::class)->orderBy('position')->withPivot('group');
    }

    public function getCodesAttribute()
    {
        return $this->codes()->get()->sortBy('pivot.group')->groupBy('pivot.group');
    }
}
