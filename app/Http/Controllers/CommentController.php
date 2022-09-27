<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    //
    public function store(Request $request)
    {
        $comment = new Comment;

        $comment->comment = $request->comment;
        $comment->post_id = $request->id;
        $comment->user_id = \Auth::user()->id;
       
        $comment->save();
    
        return redirect(route('posts.show', [$request['id']]));
 
    }

    public function delete(Request $request,$id){
        Comment::where('id', $id)->delete();
        return redirect(route('posts.show', [$request['id']]));//取得したIDに戻る
    }
}
