<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function scopeUsers($query){
        return $query->where('id', '!=', auth()->user()->id);
    }



    /* Листа на корисници кои јас ги следам
    /* user_id се id кои јас ги следам */
    public function following(){
        return $this->belongsToMany(Self::class, 'followers','user_id', 'follows_id')->withTimestamps();
    }
    
    /* Листа на корисници кои тие ме следат */
    /* follows_id се id кои тие ме следат */
   /* public function followers(){
        return $this->belongsToMany(Self::class,'followers','follows_id','user_id')->withTimestamps();
    }*/


    public function is_following($user_id){
        return $this->following()->where('follows_id', $user_id)->first();
    }

    public function follow($user_id){
        $this->following()->attach($user_id);
    }

    public function unfollow($user_id){
        $this->following()->detach($user_id);
    }

    /*public function follow($userId) 
    {
        $this->following()->attach($userId);
        return $this;
    }

    public function unfollow($userId)
    {
        $this->following()->detach($userId);
        return $this;
    }

    public function isFollowing($userId) 
    {
        return (boolean) $this->following()->where('follows_id', $userId)->first();
    }*/


}
