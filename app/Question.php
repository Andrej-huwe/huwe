<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable=['score','actualScore', 'awardOne','awardTwo','awardThree','awardFour','awardFive','awardSix',];
}
