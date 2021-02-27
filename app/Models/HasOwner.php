<?php


namespace App\Models;


trait HasOwner
{
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
}
