<?php

namespace Blog\Models;

use Blog\Jobs\SendPostUpdateEmailJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    /**
     * Guarded fields
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Automatically loaded relations
     * @var array
     */
    protected $with = ['user', 'category', 'tags'];

    /**
     * Field Type casts
     * @var array
     */
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

    /**
     * Category relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tags relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Cover attribute accessor
     *
     * @param string $cover
     * @return string
     */
    public function getCoverAttribute($cover)
    {
        return '/storage/' . ($cover ?? 'covers/default.jpg');
    }

    /**
     * Cover attribute mutator
     *
     * @param string $cover
     * @return void
     */
    public function setCoverAttribute($cover)
    {
        $cover = $cover ? $cover->storeAs(
            'covers',
            md5($cover->getClientOriginalName()) . '.' . $cover->getClientOriginalExtension()
        ) : null;

        $this->attributes['cover'] = $cover;
    }

    /**
    * Filter tag scope
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param \Blog\Models\Tag $tag
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeFilterTag(Builder $query, Tag $tag)
    {
        return $query->whereHas('tags', function ($query) use ($tag) {
            $query->where('tag_id', $tag->id);
        });
    }

    /**
    * Filter tag scope
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param \Blog\Models\Category $category
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeFilterCategory(Builder $query, Category $category)
    {
        return $query->where('category_id', $category->id);
    }
}
