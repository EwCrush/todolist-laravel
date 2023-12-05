<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserList;
use App\Models\Task;

class UserListController extends Controller
{
    public function addNewList(Request $request){
        if(!$request->userListName) return back();
        $user_id = session('dataTodoMiddleware')['user']->id;
        UserList::create([
            'name' => $request->userListName,
            'type' => 'custom',
            'user' => $user_id,
        ]);
        return back();
    }

    public function deleteList($id){
        if(!$id) return back();
        $user_id = session('dataTodoMiddleware')['user']->id;
        if(!$user_id) return back();

        $list = UserList::where('id', $id)->first();

        if(!$list) return back();
        if($list->user != $user_id) return back();
        if($list->type == 'default') return back();

        //tìm default list
        $defaultList = UserList::where('type', 'default')->firstOr(function () use ($user_id) {
            return UserList::create([
                'name' => 'Mặc định',
                'type' => 'default',
                'user' => $user_id,
            ]);
        });
        //tìm task có list_id trùng với id được truyền vào
        $tasks = Task::where('list', $id)->get();
        //thay thế list = default
        foreach ($tasks as $item) {
            $item->update([
                'list' => $defaultList->id,
            ]);
        }
        //xóa list
        $list->delete();
        return back();
    }
}
