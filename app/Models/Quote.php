<?php

namespace App\Models;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;


class Quote extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['body'];

    protected $guarded = ['id'];

    public function scopeFilter($query, $searchTerm)
    {
        if ($searchTerm) {
            if (Str::startsWith($searchTerm, '@')) {
                $movieTitle = Str::substr($searchTerm, 1);
                return $query->whereHas('movie', function ($query) use ($movieTitle) {
                    $query->whereRaw("json_extract(title, '$.en') LIKE ?", ["%{$movieTitle}%"])
                        ->orWhereRaw("json_extract(title, '$.ka') LIKE ?", ["%{$movieTitle}%"]);
                });
            } else if (Str::startsWith($searchTerm, '3')) {
                $quoteText = Str::substr($searchTerm, 1);
                return $query->whereRaw("json_extract(body, '$.en') LIKE ?", ["%{$quoteText}%"])
                    ->orWhereRaw("json_extract(body, '$.ka') LIKE ?", ["%{$quoteText}%"]);
            }

            return $query->whereHas('movie', function ($query) use ($searchTerm) {
                $query->whereRaw("json_extract(title, '$.en') LIKE ?", ["%{$searchTerm}%"])
                    ->orWhereRaw("json_extract(title, '$.ka') LIKE ?", ["%{$searchTerm}%"]);
            })
                ->orWhereRaw("json_extract(body, '$.en') LIKE ?", ["%{$searchTerm}%"])
                ->orWhereRaw("json_extract(body, '$.ka') LIKE ?", ["%{$searchTerm}%"]);
        }

        return $query;
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}
