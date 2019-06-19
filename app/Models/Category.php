<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'comment', 'parent_id',
    ];

    public function parent(){
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children(){
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function transactions(){
        return $this->hasMany('App\Models\Transaction');
    }
}
