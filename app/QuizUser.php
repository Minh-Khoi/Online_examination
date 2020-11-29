<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizUser extends Model
{
    /** This is the attributes which can be filled by custom 's values */
    protected $fillable = ["id", "quiz_id", "user_id"];
    protected $append = ['point'];

    /**
     * Calculate the point of exam (QuizUser instance)
     */
    public function getPointAttribute()
    {
        $results_list = Result::where('quiz_user_id', $this->id)->get()->all();
        if (count($results_list) == 0) {
            return 0;
        }
        $point = 0;
        foreach ($results_list as $k => $results) {
            $answer = Answer::find($results->answer_id);
            $point += ($answer->is_correct) ? 1 : 0;
        }
        return $point / (count($results_list)) * 10;
    }
}