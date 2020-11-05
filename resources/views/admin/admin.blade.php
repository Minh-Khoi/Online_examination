@extends('layouts.container_layout')

@section('subcontent')
<div class="container" id="app">
    <router-view></router-view>

</div>
<script>
    window.current_user = {{$current_user}}
</script>

@endsection
