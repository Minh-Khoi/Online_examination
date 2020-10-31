<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizUser extends Model
{
    /** This is the attributes which can be filled by custom 's values */
    protected $fillable = ["id", "quiz_id", "user_id"];
}