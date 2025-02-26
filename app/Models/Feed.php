<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Models\like;

class Feed extends Model
{

    protected $fillable = [
        'user_id',
        'content'
    ];

    protected $appends =['liked'];

    public function user():BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function getLikedAttribute(): bool {
        return Like::where('feed_id', $this->id)
                   ->where('user_id', Auth::id())
                   ->exists();
    }
    

    
}
