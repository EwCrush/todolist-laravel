@extends('layouts.user')
@section('sidebar')
    <aside class="bg-white shadow-md min-h-screen">
        <div class="h-full w-full">
            <div class="flex items-center py-4 px-3 space-x-4">
                <img class="w-10 h-10 rounded-full" src="{{ session('dataTodoMiddleware')['user']->image }}" alt="">
                <div class="font-medium dark:text-white">
                    <span
                        class="line-clamp-1 text-sm font-semibold">{{ session('dataTodoMiddleware')['user']->fullname }}</span>
                    <div class="line-clamp-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ session('dataTodoMiddleware')['user']->username_account }}</div>
                </div>
            </div>
            <ul>
                <li
                    class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer @if ($routename == 'today') bg-sidebarselected @endif">
                    <a href="{{ route('today') }}" class="flex items-center text-gray-700 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-calendar-day"></i>
                        Hôm nay
                    </a>
                </li>
                <li
                    class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer @if ($routename == 'next7days') bg-sidebarselected @endif">
                    <a href="{{ route('next7days') }}" class="flex items-center text-gray-700 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-calendar-week"></i>
                        7 ngày tới
                    </a>
                </li>
                <li
                    class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer @if ($routename == 'alltasks') bg-sidebarselected @endif">
                    <a href="{{ route('alltasks') }}" class="flex items-center text-gray-700 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-rectangle-list"></i>
                        Tất cả task
                    </a>
                </li>

            </ul>
            <hr class="my-1" />
            <div class="py-2 px-3 text-base flex justify-between items-center hover:bg-zinc-100 cursor-pointer">
                <span>List</span>
                <span title="Thêm list mới" class="hover:text-primary cursor-pointer"><i
                        class="fa-solid fa-plus"></i></span>
            </div>
            <ul>
                @foreach (session('dataTodoMiddleware')['lists'] as $list)
                    <li class="py-2 px-3 text-sm hover:bg-zinc-100 cursor-pointer">
                        <a href="#" class="flex items-center text-gray-700 hover:text-blue-600">
                            <i class="mr-2 fa-solid fa-list"></i>
                            {{ $list->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <hr class="my-1" />
            <div class="py-2 px-3 text-base flex justify-between items-center hover:bg-zinc-100 cursor-pointer">
                <span>Tag</span>
                <span title="Thêm tag mới" class="hover:text-primary cursor-pointer"><i class="fa-solid fa-plus"></i></span>
            </div>
            <ul>
                @foreach (session('dataTodoMiddleware')['tags'] as $tag)
                    <li class="py-2 px-3 text-sm hover:bg-zinc-100 cursor-pointer">
                        <a href="#" class="flex items-center text-gray-700 hover:text-blue-600">
                            <i class="mr-2 fa-solid fa-tag"></i>
                            #{{ $tag->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <hr class="my-1" />
            <ul>
                <li class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer">
                    <a href="#" class="flex items-center text-gray-700 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-square-check"></i>
                        Đã xong
                    </a>
                </li>
                <li class="py-2 px-3 text-base hover:bg-zinc-100 cursor-pointer">
                    <a href="#" class="flex items-center text-gray-700 hover:text-blue-600">
                        <i class="mr-2 fa-solid fa-trash-can"></i>
                        Thùng rác
                    </a>
                </li>
            </ul>
        </div>
    </aside>
@endsection

@section('content')
    @yield('todothings')
@endsection
