@extends('pages.user.todo')
@section('tasks')
    <div class="flex w-full bg-white">
        <div class="min-h-screen w-3/5 py-6 px-4 shadow-md">
            <div class="w-full text-xl">
                <i class="mr-2 fa-solid fa-list"></i> {{ $title }}
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
                        <div class="relative max-w-xs">
                            <input type="date" value="{{ now()->format('Y-m-d') }}"
                                class="block w-full py-1.5 ml-1 px-2 text-gray-600 bg-border focus:bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                placeholder="Select date">
                        </div>

                    </div>

                    <!-- Danh sách công việc -->
                    @if ($overdue && count($overdue) > 0)
                        <ul class="mt-4">
                            <span class="text-xs mb-2 flex items-center"><i
                                    class="text-slate-300 mr-1 fa-solid fa-chevron-down"></i> <span class="font-bold">Đã trễ
                                    hạn</span><span
                                    class="text-slate-300 ml-1 font-semibold">{{ count($overdue) }}</span></span>
                            @foreach ($overdue as $task)
                                <li class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg">
                                    <div class="flex items-center justify-between w-full">
                                        <div class="flex items-center w-1/2">
                                            <input type="checkbox"
                                                class="w-4 h-4 mr-2 form-checkbox border-2 border-blue-500 hover:cursor-pointer">
                                            <span class="font-thin text-sm line-clamp-2">{{ $task->title }}</span>
                                        </div>
                                        <div class="">
                                            @php
                                                $tags = $task->tags->take(2);
                                                $remainingTagsCount = $task->tags->count() - count($tags);
                                                $remainingTags = $task->tags->slice(2);
                                            @endphp
                                            @foreach ($tags as $tag)
                                                <span class="text-xs text-white p-1 ml-px rounded-full"
                                                    style="background-color: {{ $tag->background_color }}">{{ $tag->name }}</span>
                                            @endforeach

                                            @if ($remainingTagsCount > 0)
                                                <span class="text-xs text-white p-1 rounded-full ml-px"
                                                    style="background-color: #ccc"
                                                    title="{{ $remainingTags->pluck('name')->implode(', ') }}">+{{ $remainingTagsCount }}</span>
                                            @endif
                                            <a href="#"
                                                class="text-xs text-slate-300 px-1 hover:cursor-pointer hover-underline">{{ $task->list_name }}
                                            </a>
                                            <span
                                                class="text-xs text-red">{{ \Carbon\Carbon::parse($task->deadline)->format('d F') }}</span>
                                        </div>
                                        {{-- \Carbon\Carbon::parse($task->deadline)->format('d F') --}}
                                    </div>
                                </li>
                                <hr class="my-0 w-full mx-auto text-border">
                            @endforeach
                        </ul>
                    @endif

                    @if ($tasksByDate && count($tasksByDate) > 0)
                        @foreach ($tasksByDate as $date => $tasks)
                            <ul class="mt-4">
                                <span class="text-xs mb-2 flex items-center"><i
                                        class="text-slate-300 mr-1 fa-solid fa-chevron-down"></i> <span
                                        class="font-bold">{{ $date }}</span><span
                                        class="text-slate-300 ml-1 font-semibold">{{ count($tasks) }}</span></span>
                                @foreach ($tasks as $task)
                                    <li
                                        class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg">
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex items-center w-1/2">
                                                <input type="checkbox"
                                                    class="w-4 h-4 mr-2 form-checkbox border-2 border-blue-500 hover:cursor-pointer">
                                                <span class="font-thin text-sm line-clamp-2">{{ $task->title }}</span>
                                            </div>
                                            <div class="">
                                                @php
                                                    $tags = $task->tags->take(2);
                                                    $remainingTagsCount = $task->tags->count() - count($tags);
                                                    $remainingTags = $task->tags->slice(2);
                                                @endphp
                                                @foreach ($tags as $tag)
                                                    <span class="text-xs text-white p-1 ml-px rounded-full"
                                                        style="background-color: {{ $tag->background_color }}">{{ $tag->name }}</span>
                                                @endforeach

                                                @if ($remainingTagsCount > 0)
                                                    <span class="text-xs text-white p-1 rounded-full ml-px"
                                                        style="background-color: #ccc"
                                                        title="{{ $remainingTags->pluck('name')->implode(', ') }}">+{{ $remainingTagsCount }}</span>
                                                @endif
                                                <a href="#"
                                                    class="text-xs text-slate-300 px-1 hover:cursor-pointer hover-underline">{{ $task->list_name }}
                                                </a>
                                                <span
                                                    class="text-xs text-primary">{{ \Carbon\Carbon::parse($task->deadline)->format('d F') }}</span>
                                            </div>
                                            {{-- \Carbon\Carbon::parse($task->deadline)->format('d F') --}}
                                        </div>
                                    </li>
                                    <hr class="my-0 w-full mx-auto text-border">
                                @endforeach
                            </ul>
                        @endforeach
                    @endif

                    @if ($isDone && count($isDone) > 0)
                        <ul class="mt-4">
                            <span class="text-xs mb-2 flex items-center"><i
                                    class="text-slate-300 mr-1 fa-solid fa-chevron-down"></i> <span class="font-bold">Đã
                                    xong</span><span
                                    class="text-slate-300 ml-1 font-semibold">{{ count($isDone) }}</span></span>
                            @foreach ($isDone as $task)
                                <li
                                    class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg hover:cursor-pointer">
                                    <div class="flex items-center">
                                        <input type="checkbox" checked
                                            class="w-4 h-4 mr-2 form-checkbox border-2 accent-slate-200 border-blue-500 hover:cursor-pointer">
                                        <span
                                            class="font-thin text-sm text-slate-300 line-through">{{ $task->title }}</span>
                                    </div>
                                    <div class="">
                                        @php
                                            $tags = $task->tags->take(2);
                                            $remainingTagsCount = $task->tags->count() - count($tags);
                                            $remainingTags = $task->tags->slice(2);
                                        @endphp
                                        @foreach ($tags as $tag)
                                            <span class="text-xs text-white p-1 ml-px rounded-full"
                                                style="background-color: {{ $tag->background_color }}">{{ $tag->name }}</span>
                                        @endforeach

                                        @if ($remainingTagsCount > 0)
                                            <span class="text-xs text-white p-1 rounded-full ml-px"
                                                style="background-color: #ccc"
                                                title="{{ $remainingTags->pluck('name')->implode(', ') }}">+{{ $remainingTagsCount }}</span>
                                        @endif
                                        <a href="#"
                                            class="text-xs text-slate-300 px-1 hover:cursor-pointer hover-underline">{{ $task->list_name }}
                                        </a>
                                        <span
                                            class="text-xs text-slate-300 mr-1">{{ \Carbon\Carbon::parse($task->deadline)->format('d F') }}</span>
                                        <button class="text-slate-300"><i class="fa-solid fa-circle-xmark"></i></button>
                                    </div>
                                    {{-- \Carbon\Carbon::parse($task->deadline)->format('d F') --}}
                </div>
                </li>
                <hr class="my-0 w-full mx-auto text-border">
                @endforeach
                </ul>
                @endif

            </div>
        </div>

    </div>
    <div class="min-h-screen w-2/5 p-4">test ne</div>
    </div>
@endsection
