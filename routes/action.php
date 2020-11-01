<?php

use App\Question;
use App\Quiz;
use App\QuizUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Helper\Helper;

/**
 * This Route will get list of all User instances and convert them in JSON
 */
Route::get('all_users', function () {
    // The variable below is a collection of User instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $users_list = User::all();
    return json_encode(($users_list));
});

/**
 * THis Route will find the id-specified User instance and return it (in JSON) to Client
 * with method GET
 * @param int user_id
 */
Route::get('find_user/{user_id}', function ($user_id) {
    $user = User::find($user_id);
    return  json_encode($user);
});


/**
 * This Route will get list of all Quiz instances and convert them in JSON
 */
Route::get('all_quizzes', function () {
    // The variable below is a collection of Quiz instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $quizzes_list = Quiz::all();
    return json_encode(($quizzes_list));
});

/**
 * Find Quiz instance by specified id (pass through API)
 * @param int $id
 */
Route::get('find_quiz/{id}', function ($id) {
    $quiz = Quiz::find($id);
    return json_encode($quiz);
});

/**
 * This Route will receive FormData object from Controller and create new a new Quiz instance
 * The method of this Route is POST
 */
Route::post('create_quiz', function (Request $request) {
    $quiz = new Quiz();
    $quiz->id = 0;
    $quiz->name = $request->input('name');
    $quiz->description = $request->input('description');
    $quiz->minutes = $request->input('minutes');
    $quiz->save();
    return "Create 01 Quiz successfully";
});

/**
 * This Route will receive FormData object from Controller and edit the id-specified Quiz instance
 * The method of this Route is POST
 */
Route::post('edit_quiz', function (Request $request) {
    $quiz = Quiz::find($request->input('id'));
    $quiz->name = $request->input('name');
    $quiz->description = $request->input('description');
    $quiz->minutes = $request->input('minutes');
    $quiz->save();
    return "Edited 01 Quiz successfully";
});

/**
 * This Route will receive FormData object from Controller and delete the id-specified Quiz instance
 * The method of this Route is POST
 */
Route::post('delete_quiz', function (Request $request) {
    $quiz = Quiz::find($request->input('id'));
    $quiz->delete();
    return "Delete 01 Quiz successfully";
});

/**
 * This Route will get list of all QuizUsers instances and convert them in JSON
 */
Route::get('all_exams', function () {
    // The variable below is a collection of QuizUsers instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $exams_list = QuizUser::all();
    return json_encode(($exams_list));
});

/**
 * This Route will receive FormData object from Controller and Create new QuizUser instance
 */
Route::post('create_quiz_user', function (Request $request) {
    $quiz_user = new QuizUser();
    $quiz_user->quiz_id = $request->input('quiz_id');
    $quiz_user->user_id = $request->input('user_id');
    $quiz_user->save();
    return "01 Exam has been assigned";
});

/**
 * This Route will receive FormData object from Controller and Update detail of id-specified QuizUser instance
 */
Route::post('edit_quiz_user', function (Request $request) {
    $quiz_user = QuizUser::find($request->input('id'));
    $quiz_user->quiz_id = $request->input('quiz_id');
    $quiz_user->user_id = $request->input('user_id');
    $quiz_user->save();
    return "01 Exam has been updated";
});

/**
 * This Route will receive FormData object from Controller and delete the id-specified Question instance
 * The method of this Route is POST
 */
Route::post('delete_quiz_user', function (Request $request) {
    $quiz_user = QuizUser::find($request->input('id'));
    $quiz_user->delete();
    return "Delete 01 Exam successfully";
});


/**
 * This Route will get list of all Questions instances and convert them in JSON
 */
Route::get('all_questions', function () {
    // The variable below is a collection of Questions instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $questions_list = Question::all();
    return json_encode(($questions_list));
});

/**
 * This Route will receive FormData object from Controller and create new a new Question instance
 * The method of this Route is POST
 */
Route::post('create_question', function (Request $request) {
    $question = new Question();
    $question->id = 0;
    $question->quiz_id = $request->input('quiz_id');
    $question->question_content = $request->input('question_content');
    $question->save();
    return "Create 01 Question successfully";
});

/**
 * This Route will receive FormData object from Controller and edit details of the id - specified
 *  Question instance. The method of this Route is POST
 */
Route::post('edit_question', function (Request $request) {
    $question = Question::find($request->input('id'));
    $question->quiz_id = $request->input('quiz_id');
    $question->question_content = $request->input('question_content');
    $question->save();
    return "Edited 01 Question successfully";
});

/**
 * This Route will receive FormData object from Controller and delete the id-specified Question instance
 * The method of this Route is POST
 */
Route::post('delete_question', function (Request $request) {
    $question = Question::find($request->input('id'));
    $question->delete();
    return "Delete 01 Quiz successfully";
});