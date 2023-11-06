@extends('layouts.page')
@section('content')
    @if (session('signup'))
        <script>
            let message = '{!! session('signup') !!}'
            Swal.fire({
                position: "top-right",
                icon: "success",
                title: message,
                showConfirmButton: false,
                timer: 2000,
            });
        </script>
    @endif
    @if (session('LoginFailed'))
        <script>
            let message = '{!! session('LoginFailed') !!}'
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: message,
            });
        </script>
    @endif
    <section class="bg-white dark:bg-gray-900">
        <div class="container flex items-center justify-center min-h-screen px-6 mx-auto">
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
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>

                    <input type="password" name="password" value="{{ old('password') }}"
                        class="block w-full px-10 py-3 text-gray-700 bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="Mật khẩu">
                </div>
                @error('password')
                    <small class="text-red">{{ $message }}</small>
                @enderror

                <div class="mt-6">
                    <button id="signin" type="submit"
                        class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                        Đăng nhập
                    </button>

                    <div
                        class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-neutral-300 after:mt-0.5 after:flex-1 after:border-t after:border-neutral-300">
                        <p class="mx-4 mb-0 text-center dark:text-neutral-200">Hoặc</p>
                    </div>

                    <a href="#"
                        class="flex items-center justify-center px-6 py-3 mt-4 text-gray-600 transition-colors duration-300 transform border rounded-lg dark:border-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-6 h-6 mx-2" viewBox="0 0 40 40">
                            <path
                                d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.045 27.2142 24.3525 30 20 30C14.4775 30 10 25.5225 10 20C10 14.4775 14.4775 9.99999 20 9.99999C22.5492 9.99999 24.8683 10.9617 26.6342 12.5325L31.3483 7.81833C28.3717 5.04416 24.39 3.33333 20 3.33333C10.7958 3.33333 3.33335 10.7958 3.33335 20C3.33335 29.2042 10.7958 36.6667 20 36.6667C29.2042 36.6667 36.6667 29.2042 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z"
                                fill="#FFC107" />
                            <path
                                d="M5.25497 12.2425L10.7308 16.2583C12.2125 12.59 15.8008 9.99999 20 9.99999C22.5491 9.99999 24.8683 10.9617 26.6341 12.5325L31.3483 7.81833C28.3716 5.04416 24.39 3.33333 20 3.33333C13.5983 3.33333 8.04663 6.94749 5.25497 12.2425Z"
                                fill="#FF3D00" />
                            <path
                                d="M20 36.6667C24.305 36.6667 28.2167 35.0192 31.1742 32.34L26.0159 27.975C24.3425 29.2425 22.2625 30 20 30C15.665 30 11.9842 27.2359 10.5975 23.3784L5.16254 27.5659C7.92087 32.9634 13.5225 36.6667 20 36.6667Z"
                                fill="#4CAF50" />
                            <path
                                d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.7592 25.1975 27.56 26.805 26.0133 27.9758C26.0142 27.975 26.015 27.975 26.0158 27.9742L31.1742 32.3392C30.8092 32.6708 36.6667 28.3333 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z"
                                fill="#1976D2" />
                        </svg>

                        <span class="mx-2">Đăng nhập với Google</span>
                    </a>

                    <div class="mt-6 text-center ">
                        <a href="{{ route('signup') }}" class="text-sm text-blue-500 hover:underline dark:text-blue-400">
                            Chưa có tài khoản? Đăng ký ngay
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const signIn = document.querySelector("#signin")
        const token = document.querySelector('input[name="_token"]').value
        const username = document.querySelector('input[name="username"]')
        const password = document.querySelector('input[name="password"]')

        signIn.addEventListener("click", function(e) {
            signInHandle(e);
        });

        function signInHandle(e) {
            e.preventDefault();
            const data = {
                username: username.value,
                password: password.value,
                _token: token
            };
            axios.post('/signin', data)
                .then(response => {
                    console.log(response.data);
                    // Xử lý kết quả từ phía máy chủ (nếu có)
                })
                .catch(error => {
                    const errors = error.response.data.errors;
                    for (const key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            const errorText = errors[key][0];
                            document.querySelector('.error.' + key).innerText = errorText
                        }
                    }
                });
        }
    })
</script> --}}
