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

                    @if ($deleted && count($deleted) > 0)
                        <ul class="mt-4">
                            <span class="text-xs mb-2 flex items-center"><i
                                    class="text-slate-300 mr-1 fa-solid fa-chevron-down"></i> <span class="font-bold">Đã
                                    xóa</span><span
                                    class="text-slate-300 ml-1 font-semibold">{{ count($deleted) }}</span></span>
                            @foreach ($deleted as $task)
                                @if ($task->is_completed == '1')
                                    <li
                                        class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg hover:cursor-pointer">
                                        <div class="flex items-center">
                                            <input type="checkbox" checked
                                                class="w-4 h-4 mr-2 form-checkbox border-2 accent-slate-200 border-blue-500 hover:cursor-not-allowed">
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
                                                action="{{ route('restore', ['id' => $task->id]) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                            <form id="deleteForm{{ $task->id }}"
                                                action="{{ route('deleteTask', ['id' => $task->id]) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button class="text-slate-300" title="Khôi phục"
                                                onclick="event.preventDefault(); document.getElementById('putForm{{ $task->id }}').submit();">
                                                <i class="fa-solid fa-rotate-left"></i>
                                            </button>
                                            <button title="Xóa vĩnh viễn" class="text-slate-300"
                                                onclick="event.preventDefault(); document.getElementById('deleteForm{{ $task->id }}').submit();">
                                                <i class="ml-2 fa-solid fa-trash-can"></i></button>
                                        </div>
                                        {{-- \Carbon\Carbon::parse($task->deadline)->format('d F') --}}

                                    </li>
                                    <hr class="my-0 w-full mx-auto text-border">
                                @endif
                                @if ($task->is_completed != '1' && \Carbon\Carbon::parse($task->deadline)->lessThan(\Carbon\Carbon::now()))
                                    <li
                                        class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg">
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex items-center w-1/2">
                                                <input type="checkbox"
                                                    class="w-4 h-4 mr-2 form-checkbox border-2 border-blue-500 hover:cursor-not-allowed">
                                                <span class="font-thin text-sm line-clamp-2">{{ $task->title }}</span>
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
                                                    class="text-xs text-red mr-1">{{ \Carbon\Carbon::parse($task->deadline)->format('d F') }}</span>
                                                <form id="putForm{{ $task->id }}"
                                                    action="{{ route('restore', ['id' => $task->id]) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                                <form id="deleteForm{{ $task->id }}"
                                                    action="{{ route('deleteTask', ['id' => $task->id]) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button class="text-slate-300" title="Khôi phục"
                                                    onclick="event.preventDefault(); document.getElementById('putForm{{ $task->id }}').submit();">
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                </button>
                                                <button title="Xóa vĩnh viễn" class="text-slate-300"
                                                    onclick="event.preventDefault(); document.getElementById('deleteForm{{ $task->id }}').submit();">
                                                    <i class="ml-2 fa-solid fa-trash-can"></i></button>
                                            </div>
                                            {{-- \Carbon\Carbon::parse($task->deadline)->format('d F') --}}
                                        </div>
                                    </li>
                                    <hr class="my-0 w-full mx-auto text-border">
                                @endif
                                @if ($task->is_completed != '1' && \Carbon\Carbon::parse($task->deadline)->greaterThan(\Carbon\Carbon::now()))
                                    <li
                                        class="flex items-center justify-between py-1 px-2 bg-white hover:bg-border rounded-lg">
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex items-center w-1/2">
                                                <input type="checkbox"
                                                    class="w-4 h-4 mr-2 form-checkbox border-2 border-blue-500 hover:hover:cursor-not-allowed">
                                                <span class="font-thin text-sm line-clamp-2">{{ $task->title }}</span>
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
                                                    class="text-xs mr-1 text-primary">{{ \Carbon\Carbon::parse($task->deadline)->format('d F') }}</span>
                                                <form id="putForm{{ $task->id }}"
                                                    action="{{ route('restore', ['id' => $task->id]) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                                <form id="deleteForm{{ $task->id }}"
                                                    action="{{ route('deleteTask', ['id' => $task->id]) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button class="text-slate-300" title="Khôi phục"
                                                    onclick="event.preventDefault(); document.getElementById('putForm{{ $task->id }}').submit();">
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                </button>
                                                <button title="Xóa vĩnh viễn" class="text-slate-300"
                                                    onclick="event.preventDefault(); document.getElementById('deleteForm{{ $task->id }}').submit();">
                                                    <i class="ml-2 fa-solid fa-trash-can"></i></button>
                                            </div>
                                            {{-- \Carbon\Carbon::parse($task->deadline)->format('d F') --}}
                                        </div>
                                    </li>
                                    <hr class="my-0 w-full mx-auto text-border">
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll(".form-checkbox");

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', function(e) {
                e.preventDefault();
            })
        });
    })
</script>
