@extends('index')
@section('page')
    <div class="">
        <div class="grid__row">
            <div class="grid__column-sidebar">
                @yield('sidebar')
            </div>
            <div class="grid__column-content">
                content
            </div>
        </div>
    </div>
@endsection
