@extends('pages.user.todo')
@section('tasks')
    <div class="flex w-full bg-white">
        <div class="min-h-screen w-3/5 py-6 px-4 shadow-md">
            <div class="w-full text-xl">
                <i class="mr-2 fa-solid fa-list"></i> Hôm nay
            </div>
            <div class="container mx-auto mt-5">
                <div class="bg-white rounded-lg">
                    <div class="relative flex items-center mt-4 mb-8">
                        <span class="absolute left-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </span>

                        <input type="text" name="addTask"
                            class="block w-full py-2 text-gray-600 bg-border focus:bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                            placeholder="Thêm task mới">

                        <div class="relative max-w-sm">
                            <input type="date"
                            class="block w-full py-1.5 ml-1 px-2 text-gray-600 bg-border focus:bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                placeholder="Select date">
                        </div>

                    </div>

                    <!-- Danh sách công việc -->
                    <ul class="mt-4">
                        <span class="text-xs mb-2 block"><i class="text-slate-300 fa-solid fa-chevron-down"></i> <span
                                class="font-bold">Đã trễ hạn</span><span class="text-slate-300 ml-2 font-semibold">1</span></span>
                        <li
                            class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg hover:cursor-pointer">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 mr-2 form-checkbox border-2 border-blue-500 hover:cursor-pointer">
                                <span class="font-thin text-sm">Nhắn tin cho crush</span>
                            </div>
                        </li>
                        <hr class="my-0 w-full mx-auto text-border">
                    </ul>
                    <ul class="mt-4">
                        <span class="text-xs mb-2 block"><i class="text-slate-300 fa-solid fa-chevron-down"></i> <span
                                class="font-bold">Hôm nay</span><span class="text-slate-300 ml-2 font-semibold">2</span></span>
                        <li
                            class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg hover:cursor-pointer">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 mr-2 form-checkbox border-2 border-blue-500 hover:cursor-pointer">
                                <span class="font-thin text-sm">Mua sữa</span>
                            </div>
                        </li>
                        <hr class="my-0 w-full mx-auto text-border">
                        <li
                            class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg hover:cursor-pointer">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 mr-2 form-checkbox border-2 border-blue-500 hover:cursor-pointer">
                                <span class="font-thin text-sm">Ăn cơm</span>
                            </div>
                        </li>
                    </ul>
                    <ul class="mt-4">
                        <span class="text-xs mb-2 block"><i class="text-slate-300 fa-solid fa-chevron-down"></i> <span
                                class="font-bold">Đã xong</span><span class="text-slate-300 ml-2 font-semibold">2</span></span>
                        <li
                            class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg hover:cursor-pointer">
                            <div class="flex items-center">
                                <input type="checkbox" checked
                                    class="w-4 h-4 mr-2 form-checkbox border-2 accent-slate-200 border-blue-500 hover:cursor-pointer">
                                <span class="font-thin text-sm text-slate-300 line-through">Mua sữa</span>
                            </div>
                            <button class="text-slate-300"><i class="fa-solid fa-circle-xmark"></i></button>
                        </li>
                        <hr class="my-0 w-full mx-auto text-border">
                        <li
                            class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg hover:cursor-pointer">
                            <div class="flex items-center">
                                <input type="checkbox" checked
                                    class=" w-4 h-4 mr-2 form-checkbox border-2 accent-slate-200 border-blue-500 hover:cursor-pointer">
                                <span class="font-thin text-sm text-slate-300 line-through">Ăn cơm</span>
                            </div>
                            <button class="text-slate-300"><i class="fa-solid fa-circle-xmark"></i></button>
                        </li>
                    </ul>

                </div>
            </div>

        </div>
        <div class="min-h-screen w-2/5 p-4">test ne</div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // const addTask = document.querySelector('input[name="addTask"]')

        // addTask.addEventListener("click", function(e) {
        //     datepicker.datepicker();
        // });
    })
</script>
