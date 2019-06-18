<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'from', 'to', 'amount', 'description', 'tran_date', 'status',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function From(){
        return $this->belongsTo('App\Models\Account', 'from');
    }

    public function To(){
        return $this->belongsTo('App\Models\Account', 'to');
    }
}
