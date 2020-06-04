<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userName', 'fname', 'lname', 'gender', 'email', 'phone', 'password',
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

    public function managedEvents()
    {
        return $this->hasMany(Event::class, 'admin_id', 'id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)->withtimestamps();
    }

    public function purchases(){
        return $this->hasMany(Purchase::class, 'user_id', 'id');
    }

    public function sentPayments(){
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }

    public function receivedPayments(){
        return $this->hasMany(Payment::class, 'receiver_id', 'id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friend_user', 'user_id', 'friend_id');
    }

    public function addFriends(Array $users)
    {
        return $this->friends()->syncWithoutDetaching($users);
    }

    public function removeFriends(User $users)
    {
        return $this->friends()->detach($users);
    }
}
