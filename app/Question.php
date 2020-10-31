<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** This is the attributes which can be filled by custom 's values */
    protected $fillable = ["id", "question_content", "quiz_id"];
}
