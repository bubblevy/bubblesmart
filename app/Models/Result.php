<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Result extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeSearching($query, $keyword)
    {
        $query->when($keyword, function ($query, $keyword) {
            return $query->where('score', 'like', '%' . $keyword . '%')
                ->orWhere('created_at', 'like', '%' . $keyword . '%')
                ->orWhereHas('quiz', function ($query) use ($keyword) {
                    return $query->where('title', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%');
                });
        });
    }

    public function scopeSearchingAccess($query, $keyword)
    {
        $query->when($keyword, function ($query, $keyword) {
            return $query->where('score', 'like', '%' . $keyword . '%')
                ->orWhere('created_at', 'like', '%' . $keyword . '%')
                ->orWhereHas('user', function ($query) use ($keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%')->orWhere('gender', 'like', '%' . $keyword . '%');
                });
        });
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answer_user(): HasMany
    {
        return $this->hasMany(Answer_user::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
