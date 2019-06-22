<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{

    public function Subject(){
        return $this->belongsTo('App\Subject');
    }
}
