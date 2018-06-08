<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'cover_img', 'description'];

    //
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
