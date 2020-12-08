<?php

/**
 * This route file ('routes/action.php') was created to handle all the logical business with data
 * before send it to Controller on Client-side. Actually, It 's working as an Action class.
 * But the Controller can only call it by HTTP request: AJAX, FETCH API (instead of importing modules)
 */

use App\Answer;
use App\Question;
use App\Quiz;
use App\QuizUser;
use App\Result;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
 * THis Route will return detail of the loged-in user in JSON
 */
Route::get('current_user', function () {
    $current_user = Auth::user();
    if ($current_user) {
        return json_encode($current_user);
    }
    return false;
});

/**
 * This Route will receive request from client which is an array of "user_id",
 * then find the corresponding User instances and change the attribute "is_admin" to '1'
 */
Route::post('create_user_admin', function (Request $request) {
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
    $array_of_user_id = $request->input('user_id');
    foreach ($array_of_user_id as $k => $id) {
        $user = User::find($id);
        $user->is_admin = 1;
        $user->save();
    }
    return "Update User successfully";
});

/**
 * This Route will receive request from client which is an array of "user_id",
 * then find the corresponding User instances and change the attribute "is_admin" to '0'
 */
Route::post('unset_user_admin', function (Request $request) {
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
    $array_of_user_id = $request->input('user_id');
    foreach ($array_of_user_id as $k => $id) {
        $user = User::find($id);
        $user->is_admin = 0;
        $user->save();
    }
    return "Update User successfully";
});

/**
 * This Route will receive request from client which is an array of "user_id",
 * then find the corresponding User instances and DELETE it
 */
Route::post('delete_user', function (Request $request) {
    if (Auth::user()->is_admin) {
        $id = $request->input('user_id');
        $user = User::find($id);
        $user->delete();
        return "Update User successfully";
    } else {
        return "You have no permission to delete or update data";
    }
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
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
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
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
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
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
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
 * This Route will get list of all QuizUsers instances which have the specified user_id (passed from client)
 *  and convert them in JSON
 */
Route::get('all_exams_with_user_id/{user_id}', function ($user_id) {
    // The variable below is a collection of QuizUsers instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $exams_list = QuizUser::where('user_id', $user_id)->get();
    return json_encode(($exams_list));
});

/**
 * This Route will get list of all QuizUsers instances which have the specified user_id (passed from client)
 *  and convert them in JSON
 */
Route::get('all_exams_with_quiz_id/{quiz_id}', function ($quiz_id) {
    // The variable below is a collection of QuizUsers instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $exams_list = QuizUser::where('quiz_id', $quiz_id)->get();
    return json_encode(($exams_list));
});

/**
 * Find QuizUser instance by specified id (pass through API)
 * @param int $id question id
 */
Route::get('find_exam/{id}', function ($id) {
    $quiz_user = QuizUser::find($id);
    return json_encode($quiz_user);
});

/**
 * This Route will receive FormData object from Controller and Create new QuizUser instance
 */
Route::post('create_quiz_user', function (Request $request) {
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
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
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
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
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
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
 * This Route will get list of all Questions instances which have the same specified-passed $quiz_id
 * and convert them in JSON
 */
Route::get('all_questions_with_quiz_id/{quiz_id}', function ($quiz_id) {
    // The variable below is a collection of Questions instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $questions_list = Question::where('quiz_id', $quiz_id)->get();
    return json_encode(($questions_list));
});

/**
 * This Route will receive FormData object from Controller and create new a new Question instance
 * The method of this Route is POST
 */
Route::post('create_question', function (Request $request) {
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
    $question = new Question();
    $question->id = 0;
    $question->quiz_id = $request->input('quiz_id');
    $question->question_content = $request->input('question_content');
    $question->save();
    return "Create 01 Question successfully";
});

/**
 * This Route will receive FormData object from Controller and create new a new Question instance
 * which is copied from another question with new quiz_id. Concurrentl, the Route will create all the
 * new Answer instances with is passed too.
 * The method of this Route is POST
 */
Route::post('copy_question', function (Request $request) {
    // create new Question instance with basic info
    $question = new Question();
    $question->id = $request->input('id');
    $question->quiz_id = $request->input('quiz_id');
    $question->question_content = $request->input('question_content');
    $question->save();
    // Now create Answer instances for newly created Question
    $answers_list = $request->input('answers_list');
    foreach ($answers_list as $k => $answer_info) {
        $new_answer = new Answer();
        $new_answer->question_id = $question->id;
        $new_answer->answer_content = $answer_info->answer_content;
        $new_answer->is_correct = $answer_info->is_correct;
        $new_answer->save();
    }
    return "Create 01 Question successfully";
});

/**
 * Find Question instance by specified id (pass through API)
 * @param int $id question id
 */
Route::get('find_question/{id}', function ($id) {
    $question = Question::find($id);
    return json_encode($question);
});


/**
 * This Route will receive FormData object from Controller and edit details of the id - specified
 *  Question instance. The method of this Route is POST
 */
Route::post('edit_question', function (Request $request) {
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
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
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
    $question = Question::find($request->input('id'));
    $question->delete();
    return "Delete 01 Quiz successfully";
});

/**
 * This Route will get list of all Answers instances and convert them in JSON
 */
Route::get('all_answers', function () {
    // The variable below is a collection of Answer instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $answers_list = Answer::all();
    return json_encode(($answers_list));
});

/**
 * This Route will get list of all Answers instances which have the specified question_id (passed from client)
 *  and convert them in JSON
 */
Route::get('find_answer/question/{question_id}', function ($question_id) {
    // The variable below is a collection of Answer instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $answers_list = Answer::where('question_id', $question_id)->get();
    return json_encode(($answers_list));
});


/**
 * This Route will get list of all Answers instances
 * which have the specified is_admin (passed from client, "True" or "false")
 *  and convert them in JSON
 */
Route::get('find_answer/is_correct/{is_correct}', function ($is_correct) {
    // The variable below is a collection of Answer instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $answers_list = Answer::where('is_correct', $is_correct)->get();
    return json_encode(($answers_list));
});

/**
 * This Route will receive FormData object from Controller and create new a new Answer instance
 * The method of this Route is POST
 */
Route::post('create_answer', function (Request $request) {
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
    $answer = new Answer();
    $answer->id = 0;
    $answer->question_id = $request->input('question_id');
    $answer->answern_content = $request->input('answer_content');
    $answer->save();
    return "Create 01 Answer successfully";
});

/**
 * This Route will receive FormData object from Controller and update details of the id-specified
 * Answer instance. The method of this Route is POST
 */
Route::post('edit_answer', function (Request $request) {
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
    $answer = Answer::find($request->input('id'));
    $answer->question_id = $request->input('question_id');
    $answer->answern_content = $request->input('answer_content');
    $answer->save();
    return "Updated 01 Answer successfully";
});

/**
 * This Route will receive FormData object from Controller and delete the id-specified Answer instance
 * The method of this Route is POST
 */
Route::post('delete_answer', function (Request $request) {
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
    $answer = Answer::find($request->input('id'));
    $answer->delete();
    return "Delete 01 Answer successfully";
});

/**
 * This Route will get list of all Result instances and convert them in JSON
 */
Route::get('all_results', function () {
    // The variable below is a collection of Answer instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $results_list = Result::all();
    return json_encode(($results_list));
});

/**
 * This Route will get list of all Result instances and convert them in JSON
 */
Route::get('all_results_with_user/{user_id}/and_quiz/{quiz_id}', function ($user_id, $quiz_id) {
    // The variable below is a collection of Answer instances, but we can convert it directly to JSON string.
    // It 's not neccessary to convert it to array
    $results_list = Result::where("user_id", $user_id)->where('quiz_id', $quiz_id)->get();
    return json_encode(($results_list));
});


/**
 * This Route will receive FormData object from Controller and create new a new Result instance
 * The method of this Route is POST
 */
Route::post('create_result', function (Request $request) {
    if (!(Auth::user()->is_admin)) {
        return "You have no permission to delete or update data";
    }
    $result = new Result();
    $result->id = 0;
    $result->user_id = $request->input('user_id');
    $result->quiz_id = $request->input('quiz_id');
    $result->question_id = $request->input('question_id');
    $result->answern_id = $request->input('answer_id');
    $result->save();
    return "Create 01 result successfully";
});

/**
 * Find Result instance by result 's  id (pass through API)
 * @param int $id Result id
 */
Route::get('find_result/{id}', function ($id) {
    $result = Result::find($id);
    return json_encode($result);
});

/**
 * Find Result instance by specified user id (pass through API)
 * @param int $user_id user 's id who do exam
 */
Route::get('all_results_with_user_id/user/{user_id}', function ($user_id) {
    $results_list = Result::where("user_id", $user_id)->get();
    return json_encode($results_list);
});

/**
 * Find Result instance by specified quiz id (pass through API)
 * @param int $quiz_id quiz 's id with which the user do exam
 */
Route::get('all_results_with_quiz_id/quiz/{quiz_id}', function ($quiz_id) {
    $results_list = Result::where("quiz_id", $quiz_id)->get();
    return json_encode($results_list);
});

/**
 * Find the next (auto completed) id of the instance which is going to be created
 * @param string $table_name passed through API,
 * is the name of the table in which the instance will be recorded
 */
Route::get('find_next_id/{table_name}', function (string $table_name) {
    $SQL_string = 'SELECT AUTO_INCREMENT
                    FROM information_schema.TABLES
                    WHERE TABLE_SCHEMA = "quiz_app"
                    AND TABLE_NAME = "' . $table_name . '"';
    $next_id = DB::select($SQL_string)[0]->AUTO_INCREMENT;
    return $next_id;
});
