<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable=['id', 'name', 'desc', 'difficulty', 'type', 'unlock_at'];
}
