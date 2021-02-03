<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\OnExamAction\OnExamAction;
use App\Question;
use App\Quiz;
use App\QuizUser;
use App\Result;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnExamController extends Controller
{
    /**
     * go to the Exam form (on_exam/on_exam.blade.php)
     */
    public function goToExam(Request $request)
    {
        if (!Auth::user()) {
            return "You have no permission to do the exams";
        }
        $user_id = $request->input('user_id');
        $quiz_id = $request->input('quiz_id');
        $exam_id = $request->input('exam_id');

        $quiz = Quiz::find($quiz_id);
        $user = User::find($user_id);
        // dd($quiz);
        $questions_list = Question::where('quiz_id', $quiz_id)->get()->all();
        // we will add the property "answers_list" for each Question instance of $question_list
        foreach ($questions_list as $k => $question) {
            $answers_list = Answer::where('question_id', $question->id)->get()->all();
            $question['answers_list'] = $answers_list;
            // echo $question->id;
            // print_r($answers_list);
        }
        // die();
        // add the property "question_list" for the Quiz 's instance: $quiz
        $quiz['questions_list'] = $questions_list;
        return view("on_exam.on_exam")->with('quiz_object', $quiz)->with('user_object', $user)
            ->with('exam_id', $exam_id);
    }

    /**
     * Submit exam and go to dashboard
     */
    public function submitExam(Request $request, $exam_id)
    {
        $results_collection = $request->all();
        $announce = null;
        $points = 0;
        try {
            foreach ($results_collection as $question_id => $answer_id) {
                // unexpectedly, the exam submission include the csrf_token as a request 's field.
                // It 's necessary to send a POST request in Laravel!!
                // We must avoid saving this csrf_token as a Result instance.
                // Unless the function will throw an SQLExeption
                if ($question_id != '_token') {
                    $result = new Result();
                    $result->quiz_user_id = $exam_id;
                    $result->question_id  = $question_id;
                    $result->answer_id  = $answer_id;
                    $result->save();
                    // dd($result);
                    $quiz_user = QuizUser::find($exam_id);
                    $points = $quiz_user->point;
                }
            }
            $announce = "You have done the exam number " . $exam_id . "!! And got the " . $points . " marks";
        } catch (Exception $e) {
            $announce = $e->getMessage();
        }
        // $home_controller = new HomeController();
        return redirect()->route('home.submit', ['announce' => $announce]);
    }
}