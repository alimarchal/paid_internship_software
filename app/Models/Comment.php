<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'user_id_comment_by', 'comments', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
