<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'parent_id', 'content', 'best_comment'];

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->diffForHumans();
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replyComments()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->with('user');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
