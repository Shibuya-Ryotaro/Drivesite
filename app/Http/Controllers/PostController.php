<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\MyList;

use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        
        $posts = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name')
            ->orderBy('updated_at','desc')
            ->simplePaginate($perPage = 6, $columns = ['*'], $pageName = 'posts');

        
        return view('posts/index',compact('posts'));
    }

    public function mypost()
    {
        $posts = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name')
            ->where('posts.user_id','=',\Auth::user()->id)
            ->simplePaginate($perPage = 6, $columns = ['*'], $pageName = 'posts');
        return view('mylists/mypost', compact('posts'));
    }


    //
    public function create()
    {
        return view('posts/create');
    }

    public function store(Request $request)
    {
        $validator =Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
            'address' => ['required'],
            'image' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect('/posts')
            ->withErrors($validator)
            ->withInput();
          } 


        $post = new Post;

        $post->body = $request->body;
        $post->title = $request->title;
        $post->user_id = \Auth::user()->id;
        $post->image = $request->file('image');
        
        $post->address = $request->address;
        if ($post->image) {
            $filename = request()->file('image')->getClientOriginalName();
            $post['image'] = request('image')->storeAs('public/images', $filename);
        }
   
        $post->save();

        


        return redirect('posts/index')->with('flash_message', '投稿が完了しました');
    }

    public function show($id)
    {
        $post = Post::find($id); //メインキーを検索

   
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->select('users.name', 'comments.comment', 'comments.created_at', 'comments.user_id', 'comments.id')
            ->where('comments.post_id', '=', $id)
            ->get();

        $mylist = '';
        if (\Auth::user() != null) {
            $mylists = MyList::where('post_id', $id)->where('user_id', \Auth::user()->id)->get();
            // // dd(count($mylists));
            if (count($mylists) <= 1) {
                $mylist = false;
            } else {
                $mylist = $mylists[0]->id;
            }
        }


        $mylistCount = DB::table('my_lists')

        ->select('my_lists.id')
        ->where('my_lists.post_id', '=', $id)
        ->count();

        return view('posts/show', compact('post', 'comments', 'mylist', 'mylistCount'));
    }

    public function edit($id)
    {
        $post = Post::find($id);
        if (is_null($post)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect('/');
        }
        return view('posts/edit', compact('post'));
    }

    public function update(Request $request)
    {
        $inputs = $request->all();

        $post = Post::find($inputs['id']);
        $post->fill([
            'title' => $inputs['title'],
            'body' => $inputs['body'],
            'address' => $inputs['address'],
        ]);
        if ($post->image) {
            $filename = request()->file('image')->getClientOriginalName();
            $post['image'] = request('image')->storeAs('public/images', $filename);
        }
        $post->user_id = \Auth::user()->id;

        $post->save();
        return redirect('posts/index');
    }

    public function delete($id)
    {
        Post::where('id', $id)->delete();
        return redirect('/');
    }
}
