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
        return view('pages.user.defaultOptions.next7days', [
            'routename' => 'next7days'
        ]);
    }

    public function alltasks (){
        return view('pages.user.defaultOptions.alltasks', [
            'routename' => 'alltasks'
        ]);
    }
}
