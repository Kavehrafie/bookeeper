<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Tags\HasTags;
use App\Models\Reference;

class Code extends Model
{
    use HasFactory, HasTags, SoftDeletes, HasOwner;

    protected $fillable = [
        'body',
        'pages',
        'reference_id',
        'notes',
    ];

    protected $casts = [
        'notes' => 'array'
    ];

    protected $appends = ['referenceTitle'];

    public function getReferenceTitleAttribute()
    {
        $reference = $this->reference;
        if (empty($reference)) return 'No reference found.';
        $authors = array_reduce($reference->authors->values()->toArray() ?? [], function($carry, $item){
            $carry .= $item . '  ';
            return $carry;
        });

        return $authors . ' ('. $reference->year . '). ' . $reference->title;
    }

    public function reference()
    {
        return $this->belongsTo(Reference::class);
    }

    public function notes()
    {
        return $this->hasMany(Notes::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['tags'] ?? null, function ($query, $tag) {
            $query->withAllTags($tag);
        })->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('body', 'like', '%'.$search.'%');
        })->when($filters['references'] ?? null, function ($query, $references) {
            $query->whereHas('reference', function (Builder $query) use ($references) {
                $query->whereIn('id', $references);
            });
        });
    }
}
