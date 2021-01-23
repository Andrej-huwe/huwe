<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable=['id', 'user_id','total_score','words_score','sentences_score','nouns_score','verbs_score','adjectives_score','pronouns_score'];
}
