<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

class Reference extends Model
{
    use HasFactory, SoftDeletes, HasTags;

    protected $fillable = [
        'title',
        'year',
        'publisher_id',
        'city',
        'type',
        'volume',
        'journal' .
        'issue',
        'pages'
    ];

    protected $appends = ['authors', 'editors'];

    public function userables()
    {
        return $this->morphToMany(User::class, 'userable');
    }

    public function people()
    {
        return $this->belongsToMany(Author::class)->withPivot('role');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function getAuthorsAttribute()
    {
        return $this->people()
            ->where('author_reference.role', 'author')
            ->get()
            ->pluck('tag', 'id');
    }

    public function getEditorsAttribute()
    {
        return $this->people()
            ->where('author_reference.role', 'editor')
            ->get()
            ->pluck('tag', 'id');
    }
}
