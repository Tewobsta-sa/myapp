<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class like extends Model
{
    protected $fillable = [
        'feed_id',
        'user_id'
    ];

    public function feed(){
        return $this->belongsTo(User::class);
    }

    public function likes():HasMany{
        return $this->hasMany(Like::class);
    }
}
