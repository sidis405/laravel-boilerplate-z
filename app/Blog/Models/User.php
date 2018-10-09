<?php

namespace Blog\Models;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isAuthorOf(Post $post)
    {
        return $this->id == $post->user_id;
    }

    public function createAndSyncFrom(Request $request)
    {
        $post = $request->user()->posts()->create($request->validated());

        $post->tags()->sync($request->tags);

        return $post;
    }

    public function updateAndSyncFrom(Post $post, Request $request)
    {
        $post->update($request->validated());

        $post->tags()->sync($request->tags);

        return $post;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
