<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Tags\HasTags;
use App\Models\Reference;

class Code extends Model
{
    use HasFactory, HasTags, SoftDeletes;

    protected $fillable = [
        'body',
        'pages',
        'reference_id',
        'notes',
    ];

    protected $casts = [
        'notes' => 'json'
    ];

    protected $appends = ['referenceTitle'];

    public function getReferenceTitleAttribute()
    {
        $reference = $this->reference;
        $authors = array_reduce(json_decode(json_encode($reference->authors), true), function($carry, $item){
            $carry .= $item . '  ';
            return $carry;
        });

        return $authors . ' ('. $reference->year . '). ' . $reference->title;
    }

    public function userables()
    {
        return $this->morphToMany(User::class, 'userable');
    }

    public function scopeOwnedByCurrentUser($query)
    {
        $query->whereHas('userables', function ($query) {
            $query->where('id', auth()->id());
        });
    }

    public function reference()
    {
        return $this->belongsTo(Reference::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['tag'] ?? null, function ($query, $tag) {
            $query->withAnyTags($tag);
        });
//        $query->when($filters['search'] ?? null, function ($query, $search) {
//            $query->where('name', 'like', '%'.$search.'%');
//        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
//            if ($trashed === 'with') {
//                $query->withTrashed();
//            } elseif ($trashed === 'only') {
//                $query->onlyTrashed();
//            }
//        });
    }
}
