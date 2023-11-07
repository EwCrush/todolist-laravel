@extends('index')
@section('page')
    <div class="grid">
        <div class="grid__row">
            <div class="grid__column-sidebar">
                @yield('sidebar')
            </div>
            <div class="grid__column-content">
                @yield('content')
            </div>
        </div>
    </div>
@endsection
