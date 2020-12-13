<?php

use Illuminate\Support\Facades\Route;

Route::post('on_exam', "OnExamController@goToExam")->name('exam.goto');

Route::post('submit_exam/{exam_id}', "OnExamController@submitExam")->name('exam.submit');