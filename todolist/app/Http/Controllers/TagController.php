<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function addNewTag(Request $request){
        if(!$request->tagName) return back();
        $background_color = $request->tagColor;
        $tagName = str_replace(' ', '', $request->tagName);
        $user_id = session('dataTodoMiddleware')['user']->id;
        Tag::create([
            'name' => $tagName,
            'background_color' => $background_color,
            'user' => $user_id,
        ]);
        return back();
    }
}
