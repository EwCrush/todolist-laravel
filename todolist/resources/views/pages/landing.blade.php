@extends('layouts.page')
@section('content')
    <div class="bg-gradient-to-r from-blue-500 to-green-500 h-screen flex items-center justify-center">

        <div class="bg-white p-8 rounded shadow-md w-full md:w-1/2 lg:w-1/3">
            <h1 class="text-3xl font-bold mb-4">Welcome to Any.do</h1>
            <p class="text-gray-600 mb-6">Manage your tasks easily with our simple and intuitive Any.do.</p>
            <a href="{{ route('signin') }}" class="bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Get Started</a>
        </div>

    </div>
@endsection
