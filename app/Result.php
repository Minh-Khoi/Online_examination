<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    /** This is the attributes which can be filled by custom 's values */
    protected $fillable = ["id", "quiz_user_id", "question_id", "answer_id"];
}
