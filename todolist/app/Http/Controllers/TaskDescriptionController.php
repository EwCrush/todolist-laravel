<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\DescriptionTag;
use App\Models\UserList;
use App\Models\Tag;
use Carbon\Carbon;

class TaskDescriptionController extends Controller
{
    public function getTaskDescription($id, Request $request){
        $routename = $request->query('type');
        $user_id = session('dataTodoMiddleware')['user']->id;

        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')
        ->where('user_lists.user', $user_id)
        ->where('tasks.id', $id)
        ->orderBy('deadline', 'desc')
        ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type', 'user_lists.id as list_id')
        ->first();

        if(!$task) return back();

        $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                    ->where('task', $task->id)
                    ->select('description_tags.*', 'tags.name', 'tags.background_color')
                    ->get();

        $lists = UserList::where('user', $user_id)->get();

        //mảng các tag đã được sử dụng trong task
        $usedTagIds = $task->tags->pluck('tag')->toArray();

        //lấy ra các tag chưa được sử dụng trong tag này
        $tagsNotSelected = Tag::where('user', $user_id)
            ->whereNotIn('id', $usedTagIds)
            ->get();

        return view('pages.user.description', compact('routename', 'task', 'lists', 'tagsNotSelected'));
    }

    public function removeTagFromTask($taskid, $tagid){
        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')->where('tasks.id', $taskid)->first();
        $tag = Tag::where('id', $tagid)->first();
        $user_id = session('dataTodoMiddleware')['user']->id;

        if(!$tag) return back();
        if(!$task) return back();
        if($tag->user != $user_id) return back();
        if($task->user != $user_id) return back();

        $tagNeedToRemove = DescriptionTag::where('task', $taskid)->where('tag', $tagid)->first();

        if(!$tagNeedToRemove) return back();

        $tagNeedToRemove->delete();
        return back();
    }

    public function addTagToTask($taskid, $tagid){
        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')->where('tasks.id', $taskid)->first();
        $tag = Tag::where('id', $tagid)->first();
        $user_id = session('dataTodoMiddleware')['user']->id;

        if(!$tag) return back();
        if(!$task) return back();
        if($tag->user != $user_id) return back();
        if($task->user != $user_id) return back();

        $check = DescriptionTag::where('task', $taskid)->where('tag', $tagid)->first();

        if($check) return back();

        DescriptionTag::create([
            'task' => $taskid,
            'tag' => $tagid
        ]);
        return back();
    }

    public function changeListTask($taskid, $listid){
        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')->where('tasks.id', $taskid)->first();
        $list = UserList::where('id', $listid)->first();
        $user_id = session('dataTodoMiddleware')['user']->id;

        if(!$list) return back();
        if(!$task) return back();
        if($list->user != $user_id) return back();
        if($task->user != $user_id) return back();

        $taskUpdate = Task::where('id', $taskid);

        $taskUpdate->update([
            'list' => $listid,
        ]);

        return back();
    }

    public function changeDateTask($id, Request $request){
        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')->where('tasks.id', $id)->first();
        $user_id = session('dataTodoMiddleware')['user']->id;

        if(!$task) return back();
        if($task->user != $user_id) return back();
        if (!strtotime($request->datetask)) return back();

        $taskUpdate = Task::where('id', $id);

        $taskUpdate->update([
            'deadline' => $request->datetask,
        ]);

        return back();
    }

    public function changeDescriptionTask($id, Request $request){
        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')->where('tasks.id', $id)->first();
        $user_id = session('dataTodoMiddleware')['user']->id;

        if(!$task) return back();
        if($task->user != $user_id) return back();
        if(!$request->descriptiontask) return back();

        $taskUpdate = Task::where('id', $id);

        $taskUpdate->update([
            'description' => $request->descriptiontask,
        ]);

        return back();
    }

    public function changeTitleTask($id, Request $request){
        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')->where('tasks.id', $id)->first();
        $user_id = session('dataTodoMiddleware')['user']->id;

        if(!$task) return back();
        if($task->user != $user_id) return back();
        if(!$request->titletask) return back();

        $taskUpdate = Task::where('id', $id);

        $taskUpdate->update([
            'title' => $request->titletask,
        ]);

        return back();
    }
}
