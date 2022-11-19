<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'product_description'];

//    protected $with = ['posts'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function postsApproved()
    {
        return $this->hasMany(Post::class)->where('status','approved');
    }

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->diffForHumans();
    }
}
