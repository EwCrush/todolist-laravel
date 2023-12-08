@extends('layouts.page')
@section('content')
    @if (session('cannotFind'))
        <script>
            let message = '{!! session('cannotFind') !!}'
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: message,
            });
        </script>
    @endif
    @if (session('isExist'))
        <script>
            let message = '{!! session('isExist') !!}'
            Swal.fire({
                icon: 'success',
                text: message,
            });
        </script>
    @endif
    <section class="bg-white dark:bg-gray-900">
        <div class="container flex items-center justify-center mt-28 px-6 mx-auto">
            <form class="w-full max-w-md" method="POST">
                @csrf
                <div class="relative flex items-center mt-4">
                    <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </span>

                    <input type="text" name="username" value="{{ old('username') }}"
                        class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="Tên tài khoản">
                </div>
                @error('username')
                    <small class="text-red">{{ $message }}</small>
                @enderror

                <div class="relative flex items-center mt-4">
                    <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>

                    <input type="text" name="email" value="{{ old('email') }}"
                        class="block w-full px-10 py-3 text-gray-700 bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="Email">
                </div>
                @error('email')
                    <small class="text-red">{{ $message }}</small>
                @enderror

                <div class="mt-4">
                    <button id="signin" type="submit"
                        class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                        Tìm tài khoản
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
