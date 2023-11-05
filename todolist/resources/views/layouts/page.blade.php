@extends('index')
@section('page')
    @include('components.page.header')
    <div class="">
        @yield('content')
    </div>
@endsection