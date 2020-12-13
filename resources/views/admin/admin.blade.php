@extends('layouts.container_layout')

@section('subcontent')
<div class="container" id="app">
    @if (isset($announce))
        <span data-role="alert" hidden> {{$announce}} </span>
    @endif
    <router-view></router-view>

</div>

@endsection
