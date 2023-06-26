<?php

namespace App\Models;

use App\Models\Genre;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Movie extends Model
{
    use HasFactory;

    use HasTranslations;

    public $translatable = ['title', 'director', 'description'];

    protected $guarded = ['id'];

    public function scopeFilter($query, $searchTerm)
    {
        if ($searchTerm) {
            return $query->where(function ($query) use ($searchTerm) {
                $query->whereRaw("json_extract(title, '$.ka') LIKE ?", ["%{$searchTerm}%"])
                    ->orWhereRaw("lower(json_extract(title, '$.en')) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function myQuotes(): HasMany
    {
        return $this->hasMany(Quote::class)->where('user_id', auth()->id());
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
}
