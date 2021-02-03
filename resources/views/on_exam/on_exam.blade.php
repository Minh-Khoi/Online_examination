@extends('layouts.main_layout')

@section('content')

<div data-spy="scroll" data-target="#form_exam_submit">

    <h1>This is an exam number {{$exam_id}} : {{$quiz_object->name}} </h1>

    <div class="sticky">
        <button disabled class="btn" id="remaining_time">  </button> <br>
        @foreach ($quiz_object->questions_list as $k=>$question)
            <a href="#{{$question->id}} " class="btn btn-inverse"> {{$k+1}} </a>
        @endforeach
    </div>

    <form action=" {{ url('/on_exam/submit_exam/' . $exam_id)}} " method="POST" id="form_exam_submit">
        @csrf
        <span data-time="time_of_exam" hidden> {{ $quiz_object->minutes }} </span>
        <input type="submit" value="SUBMIT THIS EXAM" style="display: inline">
        @foreach ($quiz_object->questions_list as $k=>$question)
            <ul class="nav nav-tabs nav-stacked" id=" {{$question->id}} "
                        style="background-color: aqua; color: aliceblue; font-size: 16px">
                <li style="background-color: blueviolet;
                                padding: 15px 20px; font-size: 1.2em; font-weight: 600">
                    {{$question->question_content}}
                </li>
                @foreach ($question->answers_list as $k=>$answer)
                    <li style="background-color: aqua; padding: 15px 20px; color: black ">
                        {{--
                            // let me explain this input radio: when the form submited. It will send a request
                            // which have attribute "question_id" with value "answer_id"
                            // They will be passed to an Result instance
                        --}}
                        <input type="radio" id="{{$answer->id}}"
                                                name="{{$question->id}}" value="{{$answer->id}}">
                        <label style="display: inline" for="{{$answer->id}}">
                            {{$answer->answer_content}}
                        </label>
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
            let time_of_starting = new Date().getMilliseconds();
            let remaining_time = time_of_exam *60 *1000;
            document.getElementById('remaining_time').innerHTML = (remaining_time/1000) + " seconds" ;
            let time_remaining_loading = setInterval(()=>{
                remaining_time -= 1000;
                // console.log(remaining_time);
                document.getElementById('remaining_time').innerHTML =
                                            (Math.floor(remaining_time/1000)) + ' seconds';
            }, 1000)
            setTimeout(()=>{
                // clearInterval(time_remaining_loading);
                form_submitted.submit();
            },time_of_exam *60 *1000);
        }
    </script>

</div>

@endsection
