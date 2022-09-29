<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyList;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;



class MyListController extends Controller
{
    //
    public function index(){
        $user = \Auth::user()->id;//ログイン済みかチェック
        

        $my_lists = DB::table('my_lists')
        ->join('users', 'my_lists.user_id', '=', 'users.id')
        ->join('posts', 'my_lists.post_id', '=', 'posts.id')        
        ->select('users.name', 'posts.title', 'posts.image')
        ->get();

        
        // dd($my_lists[0]);
        // dd($user);
    // dd($my_lists);

        $mylists = MyList::all(); //全て検索
        return view('mylists/index', compact('my_lists'));
    }

    public function store(Request $request)
    {
        $mylist = new MyList;
        $mylist->post_id = $request->post_id;
        $mylist->user_id = \Auth::user()->id;

        $mylist->save();

        $post = Post::find($request->post_id); //メインキーを検索
        $comments = Comment::where('post_id', $request->post_id)->get();

        
        $mylistCount = DB::table('my_lists')

        ->select('my_lists.id')
        ->where('my_lists.post_id', '=', $request->post_id)
        ->count();

        // return redirect()->route('posts.show',[$request->post_id]);
        return view('posts/show', compact('mylist','post','comments','mylistCount'));
    }


    public function delete(Request $request, $id) {
        $mylist = MyList::findOrFail($id);

        $mylist->delete();

        // return redirect()->route('posts.show',[$request->post_id]);

        // return view('posts/show', compact('mylist','post','comments'));
        return redirect (route('posts.show', $request->post_id));
    }


    public function mylist(){
        $user = \Auth::user()->id;
       
        $my_lists = DB::table('my_lists')
        ->join('users', 'my_lists.user_id', '=', 'users.id')
        ->join('posts', 'my_lists.post_id', '=', 'posts.id')        
        ->select('users.name', 'posts.title', 'posts.image','my_lists.post_id')
        ->where('my_lists.user_id','=',$user)
        ->get();



        return view('mylists/mylist', compact('my_lists'));
    }
    }

