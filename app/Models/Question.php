<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeSearching($query, $keyword)
    {
        $query->when($keyword, function ($query, $keyword) {
            return $query->where('question', 'like', '%' . $keyword . '%')
                ->orWhere('created_at', 'like', '%' . $keyword . '%')
                ->orWhereHas('answer', function ($query) use ($keyword) {
                    return $query->where('answer', 'like', '%' . $keyword . '%')->orWhere('updated_at', 'like', '%' . $keyword . '%');
                });
        });
    }

    public function answer(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answer_user(): HasMany
    {
        return $this->hasMany(Answer_user::class);
    }
}
