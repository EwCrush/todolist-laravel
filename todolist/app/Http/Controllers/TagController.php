<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\DescriptionTag;

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

    public function deleteTag($id){
        if(!$id) return back();
        $user_id = session('dataTodoMiddleware')['user']->id;
        if(!$user_id) return back();
        $tag = Tag::where('id', $id)->first();

        if(!$tag) return back();
        if($tag->user != $user_id) return back();

        //tìm tag trong description
        $descriptionTags = DescriptionTag::where('tag', $id)->get();
        //xóa tag trong description
        foreach ($descriptionTags as $item) {
            $item->delete();
        }
        //xóa tag
        $tag->delete();
        return back();
    }
}
