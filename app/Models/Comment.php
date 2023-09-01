<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use App\Models\User;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id', 'user_id', 'comments_content'
    ];

    public function comentator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
        // return response()->json('test');
    }
}
