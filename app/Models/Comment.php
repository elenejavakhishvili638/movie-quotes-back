<?php

namespace App\Models;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
