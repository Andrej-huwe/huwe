<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable=[ 'userId' ,'name','desc','unlock_at','show_at','img', 'status', 'new_award'];
}
