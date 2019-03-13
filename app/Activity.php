<?php

namespace App;

use App\Model;

class Activity extends Model
{
    protected $casts = ['changes'=> 'array'];

    public function subject(){
        return $this->morphTo();
    }
}
