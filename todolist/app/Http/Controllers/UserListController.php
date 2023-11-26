<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserList;

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
}
