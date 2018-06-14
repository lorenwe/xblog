<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PictureImgs extends Model
{
    protected $fillable = ['name', 'picture_id', 'key', 'uri', 'disk', 'size'];

    public function picture()
    {
        return $this->belongsTo(Picture::class);
    }
}
