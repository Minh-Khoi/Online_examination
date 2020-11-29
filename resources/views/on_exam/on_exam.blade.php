@extends('layouts.main_layout')
<div data-spy="scroll" data-target="#form_exam_submit">

    @section('content')
    <h1>This is an exam {{$exam_details->quiz->name}} </h1>

    <div>
        @foreach ($quiz_object->question_list as $k=>$question)
            <a href="#{{$question->id}} " class="btn btn-default"> {{$k}} </a>
        @endforeach
    </div>

    <form action="" method="POST" id="form_exam_submit">
        @csrf
        {!! Form::hidden($time_of_exam, $quiz_object->minutes) !!}
        @foreach ($quiz_object->question_list as $k=>$question)
            <ul class="nav nav-tabs nav-stacked" id=" {{$question->id}} " style="background-color: aqua">
                <li style="background-color: blueviolet">
                    {{$question->question_content}}
                </li>

                @foreach ($question->answers_list as $k=>$answer)
                    <li style="background-color: pink">
                        {{--
                            // let me explain this input radio: when the form submited. It will send a request
                            // which have attribute "question_id" with value "answer_id"
                            // They will be passed to an Result instance
                        --}}
                        <input type="radio" name="{{$question->id}} " value="{{$answer->id}} ">
                        {{$answer->answer_content}}
                    </li>
                @endforeach
            </ul>
        @endforeach
    </form>
    <script>
        window.onload = () => {
            let form_submitted = document.getElementById('form_exam_submit');
            let form_datas = new FormData(form_submitted);
            let time_of_exam = form_datas.get('time_of_exam');
            setTimeout(()=>{
                form_submitted.submit();
            },time_of_exam*60*1000);
        }
    </script>

</div>

@endsection
