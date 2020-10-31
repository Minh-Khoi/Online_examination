<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /** This is the attributes which can be filled by custom 's values */
    protected $fillable = ["question_id", "answer_content", "is_correct"];
}
