 {{-- This layout extends the layouts.main_layout  --}}
@extends('layouts.main_layout')

{{-- with the "content" like below --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="span3">
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

                </div>
                <!--/.sidebar-->
            </div>
            <!--/.span3-->

             {{-- THe "subcontent" below will contain a VUE Component --}}
            <div class="subcontent span8">
                @yield('subcontent')
            </div>
        </div>
    </div>
@endsection
