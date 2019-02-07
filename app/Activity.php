<?php

namespace App;

use App\Model;

class Activity extends Model
{
    public function subject(){
        return $this->morphTo();
    }
}
