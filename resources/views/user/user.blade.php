 {{-- This layout extends the layouts.main_layout  --}}
@extends('layouts.main_layout')

@section('content')
    <div class="container" id="app_for_user">
        <router-view></router-view>
    </div>
@endsection
