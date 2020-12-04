 {{-- This layout extends the layouts.main_layout  --}}
@extends('layouts.main_layout')

{{-- with the "content" like below --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="span3">
                @if ($current_user->is_admin)
                    <div class="sidebar">
                        <ul class="widget widget-menu unstyled">
                            <li id="dashboard">
                                <a><i class="menu-icon icon-dashboard"></i>Dashboard
                                </a>
                            </li>
                            <li id="create_quiz">
                                <a><i class="menu-icon icon-bullhorn"></i>Create Quiz </a>
                            </li>
                            <li id="view_quizzes">
                                <a><i class="menu-icon icon-inbox"></i>View Quizzes <b
                                        class="label green pull-right"> 11</b> </a>
                            </li>
                        </ul>
                        <!--/.widget-nav-->

                        <ul class="widget widget-menu unstyled">
                            <li id="view_users">
                                <a href="ui-typography.html"><i class="menu-icon icon-book"></i>View Users </a>
                            </li>
                            <li id="create_or_unset_user_admin">
                                <a href="ui-button-icon.html">
                                    <i class="menu-icon icon-bold"></i>
                                    Create/Unset ADMIN
                                </a>
                            </li>
                        </ul>
                        <!--/.widget-nav-->
                        <ul class="widget widget-menu unstyled">
                            <li id="create_exam">
                                <a href="ui-button-icon.html"><i class="menu-icon icon-bold"></i> Create Exam </a>
                            </li>
                            <li id="view_exams">
                                <a href="ui-typography.html"><i class="menu-icon icon-book"></i>View Exams </a>
                            </li>
                        </ul>

                        <ul class="widget widget-menu unstyled">
                            <li id="create_question">
                                <a href="ui-button-icon.html"><i class="menu-icon icon-bold"></i> Create Question </a>
                            </li>
                            <li id="view_questions">
                                <a href="ui-typography.html"><i class="menu-icon icon-book"></i>View Questions </a>
                            </li>
                        </ul>

                        <ul class="widget widget-menu unstyled">
                            <li id="create_answer">
                                <a href="ui-button-icon.html">
                                    <i class="menu-icon icon-bold"></i> Create Answer
                                </a>
                            </li>
                            <li id="view_answer">
                                <a href="ui-typography.html"><i class="menu-icon icon-book"></i>View Answer </a>
                            </li>
                        </ul>

                    </div>
                    <!--/.sidebar-->
                @else
                    <div class="profile-card">
                        <h1 style="font-size: 5em; color: green; padding-top: 0.5em">
                            {{$current_user->average_point}}
                        </h1>
                        <h1> {{$current_user->name}} </h1>
                        <p class="profile-title"> {{$current_user->occupation}} </p>
                        <p>{{$current_user->address}}</p>
                        <p><button>Contact: Phone {{$current_user->phone}}</button></p>
                    </div>
                    <div class="sidebar ">
                        <ul class="widget widget-menu unstyled">
                            <li id="view_quizzes_non_admin">
                                <a><i class="menu-icon icon-inbox"></i>View Quizzes <b
                                        class="label green pull-right"> 11</b> </a>
                            </li>
                        </ul>
                        <ul class="widget widget-menu unstyled">
                            <li id="view_users_non_admin">
                                <a href="ui-typography.html"><i class="menu-icon icon-book"></i>View Users </a>
                            </li>
                        </ul>
                        <ul class="widget widget-menu unstyled">
                            <li id="view_exams_non_admin">
                                <a href="ui-typography.html"><i class="menu-icon icon-book"></i>View Exam </a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
            <!--/.span3-->

             {{-- THe "subcontent" below will contain a VUE Component --}}
            <div class="subcontent span8">
                @yield('subcontent')
            </div>
        </div>
    </div>
@endsection
