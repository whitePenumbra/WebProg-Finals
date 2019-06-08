<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{ 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'photo',
        'user_id',
    ];

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->oldest();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
}