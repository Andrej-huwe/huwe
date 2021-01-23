<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable=[ 'name', 'desc', 'difficulty', 'type', 'disable', 'completed_steps'];
}
