<?php

namespace Blog\Models;

use Blog\Jobs\SendPostUpdateEmailJob;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'user_id' => 'int'
    ];

    public static function boot()
    {
        parent::boot();

        static::updated(function ($post) {
            dispatch(new SendPostUpdateEmailJob($post, auth()->user()));
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getCoverAttribute($cover)
    {
        return '/storage/' . ($cover ?? 'covers/default.jpg');
    }

    public function setCoverAttribute($cover)
    {
        $cover = $cover ? $cover->storeAs(
            'covers',
            md5($cover->getClientOriginalName()) . '.' . $cover->getClientOriginalExtension()
        ) : null;

        $this->attributes['cover'] = $cover;
    }
}
