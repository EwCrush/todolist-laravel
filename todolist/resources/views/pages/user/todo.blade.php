@extends('layouts.user')
@section('sidebar')
    <aside class="bg-white shadow-md min-h-screen">
        <div class="h-full w-full">
            <div class="flex items-center py-4 px-3 space-x-2">
                <!-- Hiển thị ảnh -->
                <img id="userImage" class="w-10 h-10 rounded-full cursor-pointer" src="{{ session('dataTodoMiddleware')['user']->image }}"
                    alt="" title="Chọn ảnh">

                <!-- Input file ẩn -->
                <form id="uploadImg" method="POST" action="{{ route('uploadImg') }}" enctype="multipart/form-data">
                    @csrf
                    <input name="image" type="file" id="imageInput" style="display: none;">
                </form>

                <div class="font-medium dark:text-white">
                    <span
                        class="line-clamp-1 text-sm font-semibold">{{ session('dataTodoMiddleware')['user']->fullname }}</span>
                    <div class="line-clamp-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ session('dataTodoMiddleware')['user']->email }}</div>
                </div>
            </div>
            <ul>
                <li
                    class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer @if ($routename == 'today') bg-sidebarselected @endif">
                    <a href="{{ route('today') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-calendar-day"></i>
                        Hôm nay
                    </a>
                </li>
                <li
                    class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer @if ($routename == 'next7days') bg-sidebarselected @endif">
                    <a href="{{ route('next7days') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-calendar-week"></i>
                        7 ngày tới
                    </a>
                </li>
                <li
                    class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer @if ($routename == 'alltasks') bg-sidebarselected @endif">
                    <a href="{{ route('alltasks') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-rectangle-list"></i>
                        Tất cả task
                    </a>
                </li>

            </ul>
            <hr class="my-1" />
            <div class="py-2 px-3 text-base flex justify-between items-center hover:bg-zinc-100 cursor-pointer">
                <span>List</span>
                <span title="Thêm list mới" class="hover:text-primary cursor-pointer"><i class="fa-solid fa-plus"
                        id="addListBtn"></i></span>
            </div>
            <form id="addListForm" class="px-2 pt-2 hidden" method="POST" action="{{ route('addNewList') }}">
                @csrf
                <input type="text" name="userListName"
                    class="block w-full text-sm py-0.5 px-2 text-gray-600 bg-border focus:bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                    placeholder="Thêm list mới">
            </form>
            <ul>
                @foreach (session('dataTodoMiddleware')['lists'] as $list)
                    <li
                        class="py-2 px-3 text-sm hover:bg-zinc-100 cursor-pointer @if ($routename == 'list-' . $list->id) bg-sidebarselected @endif">
                        <a href="{{ route('customList', ['id' => $list->id]) }}"
                            class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="mr-2 fa-solid fa-list"></i>
                            {{ $list->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <hr class="my-1" />
            <div class="py-2 px-3 text-base flex justify-between items-center hover:bg-zinc-100 cursor-pointer">
                <span>Tag</span>
                <span title="Thêm tag mới" class="hover:text-primary cursor-pointer"><i class="fa-solid fa-plus"
                        id="addTagBtn"></i></span>
            </div>
            <form id="addTagForm" class="px-2 pt-2 hidden" method="POST" action="{{ route('addNewTag') }}">
                @csrf
                <div class="flex items-center">
                    <input type="text" name="tagName"
                        class="w-4/5 text-sm py-0.5 px-2 text-gray-600 bg-border focus:bg-white border rounded-l-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="Thêm tag mới">
                    <div class="w-1/5 rounded-r-lg overflow-hidden h-8 ml-1">
                        <input type="color" name="tagColor" class="h-full w-full">
                    </div>
                </div>
            </form>
            <ul>
                @foreach (session('dataTodoMiddleware')['tags'] as $tag)
                    <li
                        class="py-2 px-3 text-sm hover:bg-zinc-100 cursor-pointer @if ($routename == 'tag-' . $tag->id) bg-sidebarselected @endif">
                        <a href="{{ route('tasksByTag', ['id' => $tag->id]) }}"
                            class="flex items-center hover:text-blue-600" style="color: {{ $tag->background_color }}">
                            <i class="mr-2 fa-solid fa-tag"></i>
                            #{{ $tag->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <hr class="my-1" />
            <ul>
                <li
                    class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer @if ($routename == 'completed') bg-sidebarselected @endif">
                    <a href="{{ route('getCompleted') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-square-check"></i>
                        Đã xong
                    </a>
                </li>
                <li
                    class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer @if ($routename == 'trash') bg-sidebarselected @endif">
                    <a href="{{ route('getTrash') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-trash-can"></i>
                        Thùng rác
                    </a>
                </li>
            </ul>
        </div>
    </aside>
@endsection

@section('content')
    @yield('tasks')
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addListBtn = document.querySelector("#addListBtn")
        const addListForm = document.querySelector("#addListForm")
        const addTagBtn = document.querySelector("#addTagBtn")
        const addTagForm = document.querySelector("#addTagForm")

        addListBtn.addEventListener("click", function(e) {
            addListForm.classList.remove('hidden');
        });

        addTagBtn.addEventListener("click", function(e) {
            addTagForm.classList.remove('hidden');
        });

        const userImage = document.getElementById('userImage');
        const imageInput = document.getElementById('imageInput');

        // Thêm sự kiện click cho ảnh
        userImage.addEventListener('click', function() {
            imageInput.click();
        });

        // Thêm sự kiện change cho input file
        imageInput.addEventListener('change', function() {
            // Kiểm tra xem đã chọn tệp tin nào chưa
            if (imageInput.files.length > 0) {
                document.getElementById('uploadImg').submit()
            }
        });

        // function signInHandle(e) {
        //     e.preventDefault();
        //     const data = {
        //         username: username.value,
        //         password: password.value,
        //         _token: token
        //     };
        //     axios.post('/signin', data)
        //         .then(response => {
        //             console.log(response.data);
        //             // Xử lý kết quả từ phía máy chủ (nếu có)
        //         })
        //         .catch(error => {
        //             const errors = error.response.data.errors;
        //             for (const key in errors) {
        //                 if (errors.hasOwnProperty(key)) {
        //                     const errorText = errors[key][0];
        //                     document.querySelector('.error.' + key).innerText = errorText
        //                 }
        //             }
        //         });
        // }
    })
</script>
