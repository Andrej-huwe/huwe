<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable=[ 'name', 'desc', 'difficulty', 'type', 'unlock_at', 'disable', 'completed_steps'];
}
