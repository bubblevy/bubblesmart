<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // searching admin data-quiz
    public function scopeSearching($query, $keyword)
    {
        $query->when($keyword, function ($query, $keyword) {
            return $query->where('status', 'like', '%' . $keyword . '%')
                ->orWhere('created_at', 'like', '%' . $keyword . '%')
                ->orWhere('title', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
        });
    }

    public function question(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function result(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
