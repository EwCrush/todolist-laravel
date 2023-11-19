<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Tag;
use App\Models\UserList;
use App\Models\User;
use App\Models\Task;
use App\Models\DescriptionTag;
use Carbon\Carbon;

class ToDoController extends Controller
{

    public function todo(){
        return redirect()->route('today');
    }

    public function today (){
        $user_id = session('dataTodoMiddleware')['user']->id;
        $routename = 'today';
        $title = 'Hôm nay';
        $icon = 'fa-solid fa-calendar-day';

        $currentDate = Carbon::now(); // Lấy ngày hiện tại

        $tasksByDate = [];

        //lấy ra các task theo từng ngày, những ngày không có task sẽ bỏ qua
            $formattedDate = 'Hôm nay';

            $tasks = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                    ->whereDate('deadline', $currentDate)
                    ->where('is_completed', 0)
                    ->where('is_deleted', 0)
                    ->where('user_lists.user', $user_id)
                    ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                    ->get();

            foreach($tasks as $task){
                $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                            ->where('task', $task->id)
                            ->select('description_tags.*', 'tags.name', 'tags.background_color')
                            ->get();
            }

            if (!$tasks->isEmpty()) {
                $tasksByDate[$formattedDate] = $tasks;
            }

        //lấy ra những task đã quá hạn
        $overdue = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->whereDate('deadline', '<', $currentDate->toDateString())
                ->where('is_completed', 0)
                ->where('is_deleted', 0)
                ->where('user_lists.user', $user_id)
                ->orderBy('deadline', 'desc')
                ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                ->get();

        foreach($overdue as $task){
            $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                        ->where('task', $task->id)
                        ->select('description_tags.*', 'tags.name', 'tags.background_color')
                        ->get();
        }

        //lấy ra những task đã hoàn thành trong hôm nay
        $isDone = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->where('is_completed', 1)
                ->where('is_deleted', 0)
                ->whereDate('deadline', '=', $currentDate->toDateString())
                ->where('user_lists.user', $user_id)
                ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                ->get();

        foreach($isDone as $task){
            $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                        ->where('task', $task->id)
                        ->select('description_tags.*', 'tags.name', 'tags.background_color')
                        ->get();
        }

        //return $tasksByDate;

        return view('pages.user.task', compact('routename', 'title', 'icon', 'tasksByDate', 'overdue', 'isDone'));
    }

    public function next7days (){
        $user_id = session('dataTodoMiddleware')['user']->id;
        $routename = 'next7days';
        $title = "7 ngày tới";
        $icon = 'fa-solid fa-calendar-week';

        $currentDate = Carbon::now(); // Lấy ngày hiện tại
        $startDate = $currentDate->addDay(); // Lấy ngày mai
        $endDate = $currentDate->copy()->addDays(7); // Lấy ngày sau 7 ngày

        $tasksByDate = [];

        //lấy ra các task theo từng ngày, những ngày không có task sẽ bỏ qua
        while ($startDate->lte($endDate)) {
            $date = $startDate->toDateString();
            $formattedDate = $startDate->format('l, d/m/Y');

            $tasks = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                    ->whereDate('deadline', $date)
                    ->where('is_completed', 0)
                    ->where('is_deleted', 0)
                    ->where('user_lists.user', $user_id)
                    ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                    ->get();

            foreach($tasks as $task){
                $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                            ->where('task', $task->id)
                            ->select('description_tags.*', 'tags.name', 'tags.background_color')
                            ->get();
            }

            if (!$tasks->isEmpty()) {
                $tasksByDate[$formattedDate] = $tasks;
            }

            $startDate->addDay();
        }

        //lấy ra những task đã quá hạn
        $overdue = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->whereDate('deadline', '<', Carbon::now()->toDateString())
                ->where('is_completed', 0)
                ->where('is_deleted', 0)
                ->where('user_lists.user', $user_id)
                ->orderBy('deadline', 'desc')
                ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                ->get();

        foreach($overdue as $task){
            $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                        ->where('task', $task->id)
                        ->select('description_tags.*', 'tags.name', 'tags.background_color')
                        ->get();
        }

        //lấy ra những task đã hoàn thành trong 7 ngày tới
        $isDone = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->where('is_completed', 1)
                ->where('is_deleted', 0)
                ->whereBetween('deadline', [Carbon::now()->addDays(1), Carbon::now()->addDays(7)])
                ->where('user_lists.user', $user_id)
                ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                ->get();

        foreach($isDone as $task){
            $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                        ->where('task', $task->id)
                        ->select('description_tags.*', 'tags.name', 'tags.background_color')
                        ->get();
        }

        // return $isDone;

        return view('pages.user.task', compact('routename', 'title', 'icon', 'tasksByDate', 'overdue', 'isDone'));
    }

    public function alltasks (){
        $user_id = session('dataTodoMiddleware')['user']->id;
        $routename = 'alltasks';
        $title = "Tất cả";
        $icon = 'fa-solid fa-rectangle-list';

        $tasksByDate = [];

        //lấy ra task có ngày lớn nhất
        $maxday = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->where('user_lists.user', $user_id)
                ->where('is_completed', 0)
                ->where('is_deleted', 0)
                ->orderBy('deadline', 'desc')->first();

        $startDate = Carbon::now();
        $endDate = $maxday ? Carbon::parse($maxday->deadline)->setTimezone('Asia/Ho_Chi_Minh')->addDay() : Carbon::now()->addDay();

        //lấy ra các task theo từng ngày, những ngày không có task sẽ bỏ qua
        while ($startDate->lte($endDate)) {
            $date = $startDate->toDateString();
            $formattedDate = $startDate->format('l, d/m/Y');

            $tasks = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                    ->whereDate('deadline', $date)
                    ->where('is_completed', 0)
                    ->where('is_deleted', 0)
                    ->where('user_lists.user', $user_id)
                    ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                    ->get();

            foreach($tasks as $task){
                $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                            ->where('task', $task->id)
                            ->select('description_tags.*', 'tags.name', 'tags.background_color')
                            ->get();
            }

            if (!$tasks->isEmpty()) {
                $tasksByDate[$formattedDate] = $tasks;
            }

            $startDate->addDay();
        }

        $overdue = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->whereDate('deadline', '<', Carbon::now()->toDateString())
                ->where('is_completed', 0)
                ->where('is_deleted', 0)
                ->where('user_lists.user', $user_id)
                ->orderBy('deadline', 'desc')
                ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                ->get();

        foreach($overdue as $task){
            $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                        ->where('task', $task->id)
                        ->select('description_tags.*', 'tags.name', 'tags.background_color')
                        ->get();
        }

        $isDone = [];

        //return $maxday->deadline;

        return view('pages.user.task', compact('routename', 'title', 'icon', 'tasksByDate', 'overdue', 'isDone'));
    }

    public function customList($id){
        $user_id = session('dataTodoMiddleware')['user']->id;
        $list = UserList::where('id', $id)->first();
        $routename = 'list-'.$id;
        $title = $list->name;
        $icon = 'fa-solid fa-list';

        if($list->user!=$user_id || $list->type=='default'){
            return back();
        }
        else {
            $tasksByDate = [];

            //lấy ra task có ngày lớn nhất
            $maxday = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                    ->where('user_lists.user', $user_id)
                    ->where('user_lists.id', $list->id)
                    ->where('is_completed', 0)
                    ->where('is_deleted', 0)
                    ->orderBy('deadline', 'desc')->first();

            $startDate = Carbon::now();
            $endDate = $maxday ? Carbon::parse($maxday->deadline)->setTimezone('Asia/Ho_Chi_Minh')->addDay() : Carbon::now()->addDay();

            //lấy ra các task theo từng ngày, những ngày không có task sẽ bỏ qua
            while ($startDate->lte($endDate)) {
                $date = $startDate->toDateString();
                $formattedDate = $startDate->format('l, d/m/Y');

                $tasks = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                        ->whereDate('deadline', $date)
                        ->where('is_completed', 0)
                        ->where('is_deleted', 0)
                        ->where('user_lists.id', $list->id)
                        ->where('user_lists.user', $user_id)
                        ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                        ->get();

                foreach($tasks as $task){
                    $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                                ->where('task', $task->id)
                                ->select('description_tags.*', 'tags.name', 'tags.background_color')
                                ->get();
                }

                if (!$tasks->isEmpty()) {
                    $tasksByDate[$formattedDate] = $tasks;
                }

                $startDate->addDay();
            }

            //lấy ra những task đã hoàn thành
            $isDone = Task::join('user_lists', 'user_lists.id', 'tasks.list')
            ->where('is_completed', 1)
            ->where('is_deleted', 0)
            ->where('user_lists.user', $user_id)
            ->where('user_lists.id', $list->id)
            ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
            ->get();

            foreach($isDone as $task){
                $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                            ->where('task', $task->id)
                            ->select('description_tags.*', 'tags.name', 'tags.background_color')
                            ->get();
            }

            $overdue = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->whereDate('deadline', '<', Carbon::now()->toDateString())
                ->where('is_completed', 0)
                ->where('is_deleted', 0)
                ->where('user_lists.user', $user_id)
                ->where('user_lists.id', $list->id)
                ->orderBy('deadline', 'desc')
                ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                ->get();

            foreach($overdue as $task){
                $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                            ->where('task', $task->id)
                            ->select('description_tags.*', 'tags.name', 'tags.background_color')
                            ->get();
            }

            return view('pages.user.task', compact('routename', 'title', 'icon', 'tasksByDate', 'overdue', 'isDone'));
        }

        // return $list->user;
    }

    public function tasksByTag($id){
        $user_id = session('dataTodoMiddleware')['user']->id;
        $tag = Tag::where('id', $id)->first();
        $routename = 'tag-'.$id;
        $title = '#'.$tag->name;
        $icon = 'fa-solid fa-tag';

        if($tag->user!=$user_id){
            return back();
        }
        else{
            $tasksByDate = [];

            //lấy ra task có ngày lớn nhất
            $maxday = Task::join('description_tags', 'tasks.id', 'description_tags.task')
                    ->join('tags', 'tags.id', 'description_tags.tag')
                    ->where('tags.user', $user_id)
                    ->where('tags.id', $tag->id)
                    ->where('is_completed', 0)
                    ->where('is_deleted', 0)
                    ->orderBy('deadline', 'desc')->first();

            $startDate = Carbon::now();
            $endDate = $maxday ? Carbon::parse($maxday->deadline)->setTimezone('Asia/Ho_Chi_Minh')->addDay() : Carbon::now()->addDay();

            while ($startDate->lte($endDate)) {
                $date = $startDate->toDateString();
                $formattedDate = $startDate->format('l, d/m/Y');

                $tasks = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                        ->join('description_tags', 'tasks.id', 'description_tags.task')
                        ->join('tags', 'tags.id', 'description_tags.tag')
                        ->where('tags.user', $user_id)
                        ->where('tags.id', $tag->id)
                        ->whereDate('deadline', $date)
                        ->where('is_completed', 0)
                        ->where('is_deleted', 0)
                        ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                        ->get();

                foreach($tasks as $task){
                    $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                                ->where('task', $task->id)
                                ->select('description_tags.*', 'tags.name', 'tags.background_color')
                                ->get();
                }

                if (!$tasks->isEmpty()) {
                    $tasksByDate[$formattedDate] = $tasks;
                }

                $startDate->addDay();
            }

            //lấy ra những task đã hoàn thành
            $isDone = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                        ->join('description_tags', 'tasks.id', 'description_tags.task')
                        ->join('tags', 'tags.id', 'description_tags.tag')
                        ->where('tags.user', $user_id)
                        ->where('tags.id', $tag->id)
                        ->where('is_completed', 1)
                        ->where('is_deleted', 0)
                        ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                        ->get();

            foreach($isDone as $task){
                $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                            ->where('task', $task->id)
                            ->select('description_tags.*', 'tags.name', 'tags.background_color')
                            ->get();
            }

            $overdue = Task::join('user_lists', 'user_lists.id', 'tasks.list')
            ->join('description_tags', 'tasks.id', 'description_tags.task')
            ->join('tags', 'tags.id', 'description_tags.tag')
            ->whereDate('deadline', '<', Carbon::now()->toDateString())
            ->where('tags.user', $user_id)
            ->where('tags.id', $tag->id)
            ->where('is_completed', 0)
            ->where('is_deleted', 0)
            ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
            ->distinct()
            ->get();

            foreach($overdue as $task){
                $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                            ->where('task', $task->id)
                            ->select('description_tags.*', 'tags.name', 'tags.background_color')
                            ->get();
            }

            //return $overdue;

            return view('pages.user.task', compact('routename', 'title', 'icon', 'tasksByDate', 'overdue', 'isDone'));
        }
    }

    public function getCompleted(){
        $user_id = session('dataTodoMiddleware')['user']->id;
        $title = "Đã xong";
        $icon = "fa-solid fa-square-check";
        $routename = "completed";

        $completed = [];

        //lấy ra task có ngày lớn nhất
        $maxday = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->where('user_lists.user', $user_id)
                ->where('is_completed', 1)
                ->where('is_deleted', 0)
                ->orderBy('deadline', 'desc')->first();

        $minday = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->where('user_lists.user', $user_id)
                ->where('is_completed', 1)
                ->where('is_deleted', 0)
                ->orderBy('deadline', 'asc')->first();

        $startDate = $minday ? Carbon::parse($minday->deadline)->setTimezone('Asia/Ho_Chi_Minh')->subDay() : Carbon::now()->addDay();
        $endDate = $maxday ? Carbon::parse($maxday->deadline)->setTimezone('Asia/Ho_Chi_Minh')->addDay() : Carbon::now()->addDay();

        while ($startDate->lte($endDate)) {
            $date = $startDate->toDateString();
            $formattedDate = $startDate->format('l, d/m/Y');

            $tasks = Task::join('user_lists', 'user_lists.id', 'tasks.list')
            ->whereDate('deadline', $date)
            ->where('is_completed', 1)
            ->where('is_deleted', 0)
            ->where('user_lists.user', $user_id)
            ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
            ->get();

            foreach($tasks as $task){
                $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                            ->where('task', $task->id)
                            ->select('description_tags.*', 'tags.name', 'tags.background_color')
                            ->get();
            }

            if (!$tasks->isEmpty()) {
                $completed[$formattedDate] = $tasks;
            }

            $startDate->addDay();
        }

        return view('pages.user.completed', compact('routename', 'title', 'icon', 'completed'));
    }

    public function getTrash(){
        $user_id = session('dataTodoMiddleware')['user']->id;
        $routename = 'trash';
        $icon = 'fa-solid fa-trash-can';
        $title = 'Đã xóa';

        $deleted = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->where('is_deleted', 1)
                ->where('user_lists.user', $user_id)
                ->orderBy('deadline', 'desc')
                ->select('tasks.*', 'user_lists.name as list_name', 'user_lists.type as list_type')
                ->get();

        foreach($deleted as $task){
            $task->tags = DescriptionTag::join('tags', 'tags.id', 'description_tags.tag')
                        ->where('task', $task->id)
                        ->select('description_tags.*', 'tags.name', 'tags.background_color')
                        ->get();
        }

        //return $deleted;

        return view('pages.user.trash', compact('routename', 'title', 'icon', 'deleted'));
    }

    public function putToTrash($id){
        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')->where('tasks.id', $id)->first();
        $user_id = session('dataTodoMiddleware')['user']->id;

        if(!$task) return back();
        if($task->user != $user_id) return back();
        if($task->is_deleted == '1') return back();

        Task::where('id', $id)->update(['is_deleted' => 1]);
        return back();
    }


    public function restore($id){
        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')->where('tasks.id', $id)->first();
        $user_id = session('dataTodoMiddleware')['user']->id;

        if(!$task) return back();
        if($task->user != $user_id) return back();
        if($task->is_deleted == '0') return back();

        Task::where('id', $id)->update(['is_deleted' => 0]);
        return back();
    }

    public function deleteTask($id){
        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')->where('tasks.id', $id)->first();
        $user_id = session('dataTodoMiddleware')['user']->id;

        if(!$task) return back();
        if($task->user != $user_id) return back();

        //xóa tag trong task description
        $description_tags = DescriptionTag::where('task', $id)->get();
        foreach ($description_tags as $item) {
            $item->delete();
        }

        Task::where('id', $id)->delete();
        return back();
    }

    public function checkCompleted($id){
        $task = Task::join('user_lists', 'user_lists.id', 'tasks.list')->where('tasks.id', $id)->first();
        $user_id = session('dataTodoMiddleware')['user']->id;

        if(!$task) return back();
        if($task->user != $user_id) return back();
        if($task->is_deleted == '1') return back();

        Task::where('id', $id)->update(['is_completed' => $task->is_completed ? 0 : 1]);

        return back();
    }

    public function addNewTask(Request $request){
        if(!$request->titletask) return back();
        $user_id = session('dataTodoMiddleware')['user']->id;
         $checkDefaultList = UserList::where('user', $user_id)->where('type', 'default')->first();

        $deadline = $request->datetask ?: Carbon::now()->toDateString();

        if($checkDefaultList){
            UserList::create([
                'name' => 'Mặc định',
                'type' => 'default',
                'user' => $user_id,
            ]);
        }

        $defaultList = UserList::where('user', $user_id)->where('type', 'default')->first();
        $list = $request->listtask ?: $defaultList->id;

        $newTask = Task::create([
            'title' => $request->titletask,
            'deadline' => $deadline,
            'is_completed' => 0,
            'is_deleted' => 0,
            'description' => '',
            'list' => $list,
        ]);

        if($request->tagtask){
            DescriptionTag::create([
                'task' => $newTask->id,
                'tag' => $request->tagtask
            ]);
        }

        return back();
        // return $list;
    }
}
