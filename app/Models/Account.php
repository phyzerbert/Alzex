<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'name', 'comment' , 'group_id',
    ];

    public function expenses(){
        return $this->hasMany('App\Models\Transaction', 'from');
    }
    
    public function incomings(){
        return $this->hasMany('App\Models\Transaction', 'to');
    }

}
