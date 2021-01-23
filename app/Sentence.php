<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    protected $fillable=[ 'name', 'desc', 'difficulty', 'type', 'disable', 'completed_steps'];
}
