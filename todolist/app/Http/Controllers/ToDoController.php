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

        return view('pages.user.task', compact('routename', 'title', 'tasksByDate', 'overdue', 'isDone'));
    }

    public function next7days (){
        $user_id = session('dataTodoMiddleware')['user']->id;
        $routename = 'next7days';
        $title = "7 ngày tới";

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

        return view('pages.user.task', compact('routename', 'title', 'tasksByDate', 'overdue', 'isDone'));
    }

    public function alltasks (){
        $user_id = session('dataTodoMiddleware')['user']->id;
        $routename = 'alltasks';
        $title = "Tất cả";

        $tasksByDate = [];

        //lấy ra task có ngày lớn nhất
        $maxday = Task::join('user_lists', 'user_lists.id', 'tasks.list')
                ->where('user_lists.user', $user_id)
                ->where('is_completed', 0)
                ->where('is_deleted', 0)
                ->orderBy('deadline', 'desc')->first();

        $startDate = Carbon::now();
        $endDate = Carbon::parse($maxday->deadline)->setTimezone('Asia/Ho_Chi_Minh')->addDay();

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

        return view('pages.user.task', compact('routename', 'title', 'tasksByDate', 'overdue', 'isDone'));
    }
}
