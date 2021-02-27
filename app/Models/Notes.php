<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $fillable = [
        'order',
        'title',
        'description',
        'code_id'
    ];

    public function code()
    {
        return $this->belongsTo(Code::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }
}
