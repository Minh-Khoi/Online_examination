@extends('layouts.container_layout')

@section('subcontent')
<div class="container" id="app">
    @if (isset($annouce))
        <span data-role="alert" hidden> {{$annouce}} </span>
    @endif
    <router-view></router-view>

</div>

@endsection
