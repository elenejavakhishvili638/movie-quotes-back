<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
                    ->orWhereRaw("json_extract(title, '$.en') LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
