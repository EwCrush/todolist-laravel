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
use Carbon\Carbon;

class ToDoController extends Controller
{

    public function todo(){
        return redirect()->route('today');
    }

    public function today (){
        return view('pages.user.defaultOptions.today', [
            'routename' => 'today'
        ]);
    }

    public function next7days (){
        // return view('pages.user.defaultOptions.next7days', [
        //     'routename' => 'next7days'
        // ]);

        $currentDate = Carbon::now(); // Lấy ngày hiện tại
        $startDate = $currentDate->addDay(); // Lấy ngày mai
        $endDate = $currentDate->copy()->addDays(7); // Lấy ngày sau 7 ngày

        $tasksByDate = [];

        //lấy ra các task theo từng ngày, những ngày không có task sẽ bỏ qua
        while ($startDate->lte($endDate)) {
            $date = $startDate->toDateString();
            $formattedDate = $startDate->format('l, d/m/Y');

            $tasks = Task::whereDate('deadline', $date)->where('is_completed', 0)->get();

            if (!$tasks->isEmpty()) {
                $tasksByDate[$formattedDate] = $tasks;
            }

            $startDate->addDay();
        }

        //lấy ra những task đã quá hạn
        $overdue = Task::whereDate('deadline', '<', Carbon::now()->toDateString())->where('is_completed', 0)->get();

        //lấy ra những task đã hoàn thành trong 7 ngày tới
        $isDone = Task::where('is_completed', 1)
                ->whereBetween('deadline', [Carbon::now()->addDays(1), Carbon::now()->addDays(7)])
                ->get();

        //return $tasksByDate;
        foreach ($tasksByDate as $date => $tasks) {
            echo "Ngày: " . $date . "\n";
            foreach ($tasks as $task) {
                echo "ID: " . $task['description'] . "\n";
                // Hiển thị các trường khác của $task nếu cần
            }
        }
    }

    public function alltasks (){
        return view('pages.user.defaultOptions.alltasks', [
            'routename' => 'alltasks'
        ]);
    }
}
