<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'title', 'slug', 'content', 'pinned', 'status'];

    protected $casts = [
        'created_at' =>'datetime:Y-m-d'
    ];

    protected $with = ['comments', 'user'];

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with('user');
    }
}
