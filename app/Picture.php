<?php

namespace App;

use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'published_at'];

    protected $fillable = ['title', 'description', 'thumbnail', 'thumbnail_info', 'img_category_id', 'user_id', 'content', 'html_content','published_at', 'status', 'json_pack'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // 重新定义全局查询作用域
        static::addGlobalScope(new PublishedScope());
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPublished()
    {
        return $this->status == 1;
    }


}
