@extends('layouts.user')
@section('sidebar')
    <aside class="bg-white shadow-md min-h-screen">
        <div class="h-full w-full">
            <div class="flex items-center py-4 px-3 space-x-2">
                <!-- Hiển thị ảnh -->
                <img id="userImage" class="w-10 h-10 rounded-full cursor-pointer"
                    src="{{ session('dataTodoMiddleware')['user']->image }}" alt="" title="Chọn ảnh">

                <!-- Input file ẩn -->
                <form id="uploadImg" method="POST" action="{{ route('uploadImg') }}" enctype="multipart/form-data">
                    @csrf
                    <input name="image" type="file" id="imageInput" style="display: none;">
                </form>

                <div class="font-medium dark:text-white">
                    <span id="fullnameText"
                        class="line-clamp-1 text-sm font-semibold">{{ session('dataTodoMiddleware')['user']->fullname }}</span>
                    <div id="emailText" class="line-clamp-1 text-xs text-gray-500 dark:text-gray-400">
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
            <div id="userListContainer"
                class="py-2 px-3 text-base flex justify-between items-center hover:bg-zinc-100 cursor-pointer">
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
            <ul class="hidden" id="listUserLists">
                @foreach (session('dataTodoMiddleware')['lists'] as $list)
                    <li
                        class="listItem flex items-center justify-between py-2 px-3 text-sm hover:bg-zinc-100 cursor-pointer @if ($routename == 'list-' . $list->id) bg-sidebarselected @endif">
                        <a href="{{ route('customList', ['id' => $list->id]) }}"
                            class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="mr-2 fa-solid fa-list"></i>
                            {{ $list->name }}
                        </a>
                        <form id="delList{{ $list->id }}Form" action="{{ route('deleteList', ['id' => $list->id]) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <span title="Xóa list" id="delList{{ $list->id }}" class="hidden red text-xs btnDelList"><i
                                class="fa-solid fa-x"></i></span>
                    </li>
                @endforeach
            </ul>
            <hr class="my-1" />
            <div id="tagContainer"
                class="py-2 px-3 text-base flex justify-between items-center hover:bg-zinc-100 cursor-pointer">
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
            <ul class="hidden" id="listTags">
                @foreach (session('dataTodoMiddleware')['tags'] as $tag)
                    <li
                        class="tagItem flex items-center justify-between py-2 px-3 text-sm hover:bg-zinc-100 cursor-pointer @if ($routename == 'tag-' . $tag->id) bg-sidebarselected @endif">
                        <a href="{{ route('tasksByTag', ['id' => $tag->id]) }}"
                            class="flex items-center hover:text-blue-600" style="color: {{ $tag->background_color }}">
                            <i class="mr-2 fa-solid fa-tag"></i>
                            #{{ $tag->name }}
                        </a>
                        <form id="delTag{{ $tag->id }}Form" action="{{ route('deleteTag', ['id' => $tag->id]) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <span title="Xóa tag" id="delTag{{ $tag->id }}" class="hidden red text-xs btnDelTag"><i
                                class="fa-solid fa-x"></i></span>
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
                @if (!session('dataTodoMiddleware')['user']->social_id)
                    <li id="settings"
                        class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer @if ($routename == 'settings') bg-sidebarselected @endif">
                        <span class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="mr-2 fa-solid fa-wrench"></i>
                            Cài đặt
                        </span>
                    </li>
                @endif
                <li
                    class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer @if ($routename == 'trash') bg-sidebarselected @endif">
                    <a href="{{ route('logout') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-right-from-bracket"></i>
                        Đăng xuất
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    {{-- modal --}}
    <div id="modal" class="hidden relative z-10 " aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div id="modalContainer"
                class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                {{-- edit profile  --}}
                <form id="editProfileItem" method="POST"
                    class="relative hidden transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="flex items-center justify-between mx-8 pt-4">
                        <span class="text-base"><i class="mr-1 fa-solid fa-user-pen"></i>Cập nhật thông tin</span>
                        <span id="goToChangePassword" class="text-primary text-sm"><i
                                class="mr-1 no-underline fa-solid fa-key"></i><span
                                class="underline hover:cursor-pointer">Đổi mật
                                khẩu</span></span>
                    </div>
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        @csrf
                        {{-- email input --}}
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                    <path
                                        d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                                    <path
                                        d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
                                </svg>
                            </div>
                            <input type="text" id="email" name="email"
                                value="{{ session('dataTodoMiddleware')['user']->email }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full ps-10 p-2.5  focus:bg-white dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                placeholder="Địa chỉ Email của bạn">
                        </div>
                        <small class="error email text-red"></small>

                        {{-- fullname input --}}
                        <label for="fullname" class="block mb-2 mt-6 text-sm font-medium text-gray-900 dark:text-white">Họ
                            tên</label>
                        <div class="flex">
                            <span
                                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                                </svg>
                            </span>
                            <input type="text" id="fullname" name="fullname"
                                value="{{ session('dataTodoMiddleware')['user']->fullname }}"
                                class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  focus:bg-white dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                placeholder="Họ tên đầy đủ của bạn">
                        </div>
                        <small class="error fullname text-red"></small>

                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" id="btnSaveEditProfile"
                            class="inline-flex w-full bg-primary justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Lưu</button>
                        <button type="button"
                            class="btnCancel mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Hủy</button>
                    </div>
                </form>
                {{-- change password --}}
                <form id="changePasswordItem" method="POST"
                    class="relative hidden transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="flex items-center justify-between mx-8 pt-4">
                        <span class="text-base"><i class="mr-1 fa-solid fa-key"></i>Đổi mật khẩu</span>
                        <span id="goToEditProfile" class="text-primary text-sm"><i
                                class="mr-1 no-underline fa-solid fa-user-pen"></i><span
                                class="underline hover:cursor-pointer">Cập nhật thông tin</span></span>
                    </div>
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        @csrf
                        {{-- old password input --}}
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mật
                            khẩu cũ</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 dark:text-gray-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="text" id="oldpassword" name="oldpassword"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full ps-10 p-2.5  focus:bg-white dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                placeholder="Mật khẩu cũ của bạn">
                        </div>
                        <small class="error oldpassword text-red"></small>

                        {{-- new password input --}}
                        <label for="email"
                            class="block mb-2 mt-6 text-sm font-medium text-gray-900 dark:text-white">Mật
                            khẩu mới</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 dark:text-gray-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="text" id="newpassword" name="newpassword"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full ps-10 p-2.5  focus:bg-white dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                placeholder="Mật khẩu mới của bạn">
                        </div>
                        <small class="error newpassword text-red"></small>

                        {{-- confirm password input --}}
                        <label for="email"
                            class="block mb-2 mt-6 text-sm font-medium text-gray-900 dark:text-white">Mật
                            khẩu xác nhận</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 dark:text-gray-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="text" id="newpassword_confirmation" name="newpassword_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full ps-10 p-2.5  focus:bg-white dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                placeholder="Xác nhận lại mật khẩu">
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" id="btnSaveChangePassword"
                            class="inline-flex w-full bg-primary justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Lưu</button>
                        <button type="button"
                            class="btnCancel mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
        const btnDelTags = document.querySelectorAll(".btnDelTag")
        const tagItems = document.querySelectorAll(".tagItem")
        const listItems = document.querySelectorAll(".listItem")
        const btnDelLists = document.querySelectorAll(".btnDelList")
        const userListContainer = document.querySelector("#userListContainer")
        const tagContainer = document.querySelector("#tagContainer")
        const listTags = document.querySelector("#listTags")
        const listUserLists = document.querySelector("#listUserLists")
        const modal = document.querySelector("#modal");
        const modalContainer = document.querySelector("#modalContainer");
        const editProfileItem = document.querySelector("#editProfileItem");
        const changePasswordItem = document.querySelector("#changePasswordItem");
        const settings = document.querySelector("#settings");
        const btnCancels = document.querySelectorAll(".btnCancel");
        const fullnameInput = document.querySelector('input[name="fullname"]')
        const emailInput = document.querySelector('input[name="email"]')
        const editProfileToken = document.querySelector('#editProfileItem input[name="_token"]')
        const btnSaveEditProfile = document.querySelector("#btnSaveEditProfile");
        const btnSaveChangePassword = document.querySelector("#btnSaveChangePassword");
        const oldPasswordInput = document.querySelector('input[name="oldpassword"]')
        const newPasswordInput = document.querySelector('input[name="newpassword"]')
        const newPasswordConfirmationInput = document.querySelector('input[name="newpassword_confirmation"]')
        const changePasswordToken = document.querySelector('#changePasswordItem input[name="_token"]')
        const goToEditProfile = document.querySelector("#goToEditProfile")
        const goToChangePassword = document.querySelector("#goToChangePassword")

        goToChangePassword.addEventListener('click', function() {
            editProfileItem.classList.add('hidden');
            changePasswordItem.classList.remove('hidden');
        })

        goToEditProfile.addEventListener('click', function() {
            editProfileItem.classList.remove('hidden');
            changePasswordItem.classList.add('hidden');
        })

        btnSaveChangePassword.addEventListener('click', function(e) {
            e.preventDefault();
            const data = {
                oldpassword: oldPasswordInput.value,
                newpassword: newPasswordInput.value,
                newpassword_confirmation: newPasswordConfirmationInput.value,
                _token: changePasswordToken.value
            };
            const accessToken = {!! json_encode(session('token')['access_token'] ?? null) !!};
            axios.put('/password', data, {
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                })
                .then(response => {
                    modal.classList.add('hidden');
                })
                .catch(error => {
                    if (error.response.status == '404') {
                        modal.classList.add('hidden');
                    } else {
                        const errors = error.response.data.errors;
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                const errorText = errors[key][0];
                                document.querySelector('.error.' + key).innerText = errorText
                            }
                        }
                    }
                });
        })

        btnSaveEditProfile.addEventListener('click', function(e) {
            e.preventDefault();
            const data = {
                fullname: fullnameInput.value,
                email: emailInput.value,
                _token: editProfileToken.value
            };
            const accessToken = {!! json_encode(session('token')['access_token'] ?? null) !!};
            axios.put('/profile', data, {
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                })
                .then(response => {
                    const fullnameText = document.querySelector("#fullnameText")
                    const emailText = document.querySelector("#emailText")
                    fullnameText.innerText = fullnameInput.value
                    emailText.innerText = emailInput.value
                    modal.classList.add('hidden');
                })
                .catch(error => {
                    if (error.response.status == '404') {
                        modal.classList.add('hidden');
                    } else {
                        const errors = error.response.data.errors;
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                const errorText = errors[key][0];
                                document.querySelector('.error.' + key).innerText = errorText
                            }
                        }
                    }
                });
        });

        btnCancels.forEach(item => {
            item.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });

        settings.addEventListener('click', function() {
            modal.classList.remove('hidden');
            editProfileItem.classList.remove('hidden');
        });

        editProfileItem.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        changePasswordItem.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        modal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });


        userListContainer.addEventListener('click', function() {
            listUserLists.classList.toggle('hidden')
        })

        tagContainer.addEventListener('click', function() {

            listTags.classList.toggle('hidden')
        })

        btnDelLists.forEach(item => {
            item.addEventListener('click', function(e) {
                Swal.fire({
                    title: "Bạn chắc chứ?",
                    text: "List này sẽ bị xóa vĩnh viễn nếu như bạn xóa nó!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Vâng, tôi hiểu!",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        const idDelForm = item.id + 'Form'
                        const delForm = document.querySelector('#' + idDelForm)
                        delForm.submit()
                    }
                });
            })
        });

        listItems.forEach(item => {
            const spanElements = item.querySelector('span');
            item.addEventListener('mouseover', function() {
                spanElements.classList.remove('hidden')
            })
            item.addEventListener('mouseout', function() {
                spanElements.classList.add('hidden')
            })
        });

        tagItems.forEach(item => {
            const spanElements = item.querySelector('span');
            item.addEventListener('mouseover', function() {
                spanElements.classList.remove('hidden')
            })
            item.addEventListener('mouseout', function() {
                spanElements.classList.add('hidden')
            })
        });

        btnDelTags.forEach(item => {
            item.addEventListener('click', function(e) {
                Swal.fire({
                    title: "Bạn chắc chứ?",
                    text: "Tag này sẽ bị xóa vĩnh viễn nếu như bạn xóa nó!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Vâng, tôi hiểu!",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        const idDelForm = item.id + 'Form'
                        const delForm = document.querySelector('#' + idDelForm)
                        delForm.submit()
                    }
                });
            })
        });

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
    })
</script>
