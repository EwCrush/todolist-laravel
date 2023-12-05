@extends('pages.user.todo')
@section('tasks')
    <div class="w-full flex justify-center">
        <div class="min-h-screen  py-4 px-4 shadow-md w-content">
            <div class="container mx-auto">
                <div class="bg-white rounded-lg">
                    <div class="flex">
                        <form class="relative flex items-center mb-2 w-4/6"
                            action="{{ route('changeTitleTask', ['id' => request()->route('id')]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <span class="absolute left-0">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input type="text" name="titletask" value="{{ $task->title }}" spellcheck="false"
                                class="block w-full py-2 text-gray-600 bg-border focus:bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                placeholder="Thay đổi tiêu đề">
                        </form>
                        <form id="changeDateForm" action="{{ route('changeDateTask', ['id' => request()->route('id')]) }}"
                            method="POST" class="relative top-1 w-1/6 mx-2">
                            @csrf
                            @method('PUT')
                            <input type="date" value="{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}"
                                name="datetask" onchange="document.getElementById('changeDateForm').submit();"
                                @if (\Carbon\Carbon::parse($task->deadline)->lessThan(\Carbon\Carbon::now())) style="color: red;" @endif
                                class="block w-full py-1.5 px-2 text-gray-600 bg-border focus:bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                placeholder="Select date">
                        </form>

                        <div class="relative top-1 w-1/6">
                            <div class="dropdown">
                                <span class="rounded-md shadow-sm">
                                    <div
                                        class="inline-flex items-center justify-between w-full py-2 px-2 text-gray-600 bg-border focus:bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40 transition duration-150 ease-in-out">
                                        <span class="mr-2">{{ $task->list_name }}</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </span>
                                <div
                                    class="dropdown-menu z-10 absolute right-0 mt-0 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                    @foreach ($lists as $list)
                                        <form id="changeListForm{{ $list->id }}"
                                            action="{{ route('changeListTask', ['taskid' => request()->route('id'), 'listid' => $list->id]) }}"
                                            method="POST" style="display: none;">
                                            @method('PUT')
                                            @csrf
                                        </form>
                                        <button
                                            onclick="event.preventDefault(); document.getElementById('changeListForm{{ $list->id }}').submit();"
                                            class="flex items-center justify-start w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <span>{{ $list->name }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative flex items-center mb-2">
                        @csrf
                        <span class="absolute left-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </span>
                        <div
                            class="flex w-5/6 min-h-TagList py-2 text-gray-600 bg-border focus:bg-white border rounded-lg pl-11 pr-4 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                            <div class="">
                                @foreach ($task->tags as $tag)
                                    <div class="relative inline-block mr-3 my-2">
                                        <form id="deleteTagForm-{{ $tag->tag }}"
                                            action="{{ route('removeTagFromTask', ['taskid' => $task->id, 'tagid' => $tag->tag]) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('delete')
                                            <span>{{ $tag->tag }}</span>
                                        </form>
                                        <span class="text-sm text-white px-2 py-1 rounded-full"
                                            style="background-color: {{ $tag->background_color }}">{{ $tag->name }}</span>
                                        <button style="background-color: {{ $tag->background_color }}"
                                            onclick="event.preventDefault(); document.getElementById('deleteTagForm-{{ $tag->tag }}').submit();"
                                            class="absolute border border-gray-50 -top-2 -right-1.5 text-slate-300 hover:cursor-pointer px-1 rounded-full hover:bg-red-500 hover:text-red-100">
                                            <span title="Xóa tag" class="text-xs text-white">x</span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="relative w-1/6 ml-2 inline-block text-left">
                            <div class="dropdown">
                                <span class="rounded-md shadow-sm">
                                    <div
                                        class="inline-flex items-center justify-between w-full py-2 px-2 text-gray-600 bg-border focus:bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40 transition duration-150 ease-in-out">
                                        <span class="mr-2">Thêm tag mới</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </span>
                                <div
                                    class="dropdown-menu z-10 absolute right-0 mt-0 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                    @foreach ($tagsNotSelected as $tag)
                                        <form id="addTagFrom{{ $tag->id }}"
                                            action="{{ route('addTagToTask', ['taskid' => request()->route('id'), 'tagid' => $tag->id]) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <button
                                            onclick="event.preventDefault(); document.getElementById('addTagFrom{{ $tag->id }}').submit();"
                                            class="flex items-center justify-start w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <span>{{ $tag->name }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <form onsubmit="preventDefault" class="relative flex items-center mb-2 w-full"
                        action="{{ route('changeDescriptionTask', ['id' => request()->route('id')]) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <span class="absolute left-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </span>
                        <textarea rows="1" name="descriptiontask" id="descriptiontask" spellcheck="false"
                            class="block w-full overflow-y-hidden py-2 text-gray-600 bg-border focus:bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                            placeholder="Mô tả chi tiết">{{ $task->description }}</textarea>
                        <div class="absolute hidden top-0 right-0 mt-2 mr-2" id="btnSaveDescription">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('descriptiontask');
        const btnSave = document.getElementById('btnSaveDescription');

        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            btnSave.style.top = (this.scrollHeight + this.offsetTop) + 'px';
        });

        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';

        textarea.addEventListener('focus', function() {
            btnSave.classList.remove('hidden');
            btnSave.style.top = (this.scrollHeight + this.offsetTop) + 'px';
        });

        textarea.addEventListener('blur', function() {
            setTimeout(function() {
                btnSave.classList.add('hidden');
            }, 500);
        });
    })
</script>
