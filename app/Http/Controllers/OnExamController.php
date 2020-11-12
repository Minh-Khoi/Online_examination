<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Quiz;
use App\User;
use Illuminate\Http\Request;

class OnExamController extends Controller
{
    /**
     * go to the Exam form (on_exam/on_exam.blade.php)
     */
    public function goToExam(Request $request)
    {
        $user_id = $request->input('user_id');
        $quiz_id = $request->input('quiz_id');
        // This variable will be pass to the view
        $object_returned = null;

        $quiz = Quiz::find($quiz_id);
        $user = User::find($user_id);

        $questions_list = Question::where('quiz_id', $quiz_id)->get()->all();
        // we will add the property "answers_list" for each Question instance of $question_list
        foreach ($questions_list as $k => $question) {
            $answers_list = Answer::where('question_id', $question->id)->get()->all();
            $question['answers_list'] = $answers_list;
        }
        // add the property "question_list" for the Quiz 's instance: $quiz
        $quiz['questions_list'] = $questions_list;
        // add the property "quiz" and "user" for the $object_returned and pass it to view
        $object_returned['quiz'] = $quiz;
        $object_returned['user'] = $user;

        return view("on_exam.on_exam")->with('exam_details', $object_returned);
    }
}
