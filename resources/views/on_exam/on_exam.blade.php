@extends('layouts.main_layout')

@section('content')

<div data-spy="scroll" data-target="#form_exam_submit">

    <h1>This is an exam number {{$exam_id}} : {{$quiz_object->name}} </h1>

    <div>
        @foreach ($quiz_object->questions_list as $k=>$question)
            <a href="#{{$question->id}} " class="btn btn-default"> {{$k+1}} </a>
        @endforeach
    </div>

    <form action=" {{ url('/on_exam/submit_exam/' . $exam_id)}} " method="POST" id="form_exam_submit">
        @csrf
        <span data-time="time_of_exam" hidden> {{ $quiz_object->minutes }} </span>
        @foreach ($quiz_object->questions_list as $k=>$question)
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
            let time_of_exam = document.querySelector('span[data-time=time_of_exam]').innerHTML;
            setTimeout(()=>{
                form_submitted.submit();
            },2500);
            //},time_of_exam*60*1000);
        }
    </script>

</div>

@endsection
