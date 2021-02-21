<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable=['id','school_id','user_name', 'user_surname', 'endTime','points', 'answers'];
}
