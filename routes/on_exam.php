<?php

use Illuminate\Support\Facades\Route;

Route::post('on_exam', "OnExamController@goToExam");

Route::post('submit_exam/{exam_id}', "OnExamController@submitExam");
