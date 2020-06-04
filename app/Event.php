<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withtimestamps();
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
