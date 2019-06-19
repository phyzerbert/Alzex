<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accountgroup extends Model
{
    protected $fillable = [
        'name', 'comment',
    ];

    public function accounts(){
        return $this->hasMany('App\Models\Account', 'group_id');
    }
}
