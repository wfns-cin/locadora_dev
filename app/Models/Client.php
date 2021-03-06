<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'gender',
        'birth_date',
        'type',
        'holder_id',
    ];

    public function holder(){
        return $this->belongsTo('App\Models\Holder');
    }
}
