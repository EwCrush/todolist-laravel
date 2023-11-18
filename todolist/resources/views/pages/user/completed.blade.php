@extends('pages.user.todo')
@section('tasks')
    <div class="w-full flex justify-center">
        <div class="min-h-screen  py-6 px-4 shadow-md w-content">
            <div class="w-full text-xl">
                <i class="mr-2 {{ $icon }}"></i> {{ $title }}
            </div>
            <div class="container mx-auto mt-5">
                <div class="bg-white rounded-lg">

                    <!-- Danh sách công việc -->

                    @if ($completed && count($completed) > 0)
                        @foreach ($completed as $date => $tasks)
                            <ul class="mt-4">
                                <span class="text-xs mb-2 flex items-center"><i
                                        class="text-slate-300 mr-1 fa-solid fa-chevron-down"></i> <span
                                        class="font-bold">{{ $date }}</span><span
                                        class="text-slate-300 ml-1 font-semibold">{{ count($tasks) }}</span></span>
                                @foreach ($tasks as $task)
                                    <li id="task-{{ $task->id }}"
                                        class="task flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg hover:cursor-pointer">
                                        <div class="flex items-center">
                                            <form id="checkForm{{ $task->id }}"
                                                action="{{ route('checkCompleted', ['id' => $task->id]) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                            <input type="checkbox" checked
                                                onchange="document.getElementById('checkForm{{ $task->id }}').submit();"
                                                class="w-4 h-4 mr-2 form-checkbox border-2 accent-slate-200 border-blue-500 hover:cursor-pointer">
                                            <span
                                                class="font-thin text-sm text-slate-300 line-through">{{ $task->title }}</span>
                                        </div>
                                        <div class="">
                                            @php
                                                $tags = $task->tags->take(3);
                                                $remainingTagsCount = $task->tags->count() - count($tags);
                                                $remainingTags = $task->tags->slice(3);
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
                                            <a href="{{ route('customList', ['id' => $task->list]) }}"
                                                class="text-xs text-slate-300 px-1 hover:cursor-pointer hover-underline">{{ $task->list_name == 'Mặc định' ? '' : $task->list_name }}
                                            </a>
                                            <span
                                                class="text-xs text-slate-300 mr-1">{{ \Carbon\Carbon::parse($task->deadline)->format('d F') }}</span>
                                            <form id="putForm{{ $task->id }}"
                                                action="{{ route('putToTrash', ['id' => $task->id]) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                            <button class="text-slate-300 ml-1"
                                                onclick="event.preventDefault(); document.getElementById('putForm{{ $task->id }}').submit();">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                            </button>
                                        </div>
                                        {{-- \Carbon\Carbon::parse($task->deadline)->format('d F') --}}
                                    </li>
                                    <hr class="my-0 w-full mx-auto text-border">
                                @endforeach
                            </ul>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tasks = document.querySelectorAll(".task");

        tasks.forEach(task => {
            task.addEventListener('click', function(e) {
                console.log(task);
            })
        });
    })
</script>
