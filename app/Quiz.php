<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    /** This is the attributes which can be filled by custom 's values */
    protected $fillable = ["id", "name", "description", "minutes"];
    protected $append = ["created_at"];
}
