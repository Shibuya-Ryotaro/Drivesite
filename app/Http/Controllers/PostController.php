<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\MyList;
;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all(); //全て検索
        return view('posts/index', compact('posts'));
    }


    //
    public function create()
    {
        return view('posts/create');
    }

    public function store(Request $request)
    {
        $post = new Post;

        $post->body = $request->body;
        $post->title = $request->title;
        $post->user_id = \Auth::user()->id;
        $post->image = $request->file('image');
        if($post->image){
            $filename=request()->file('image')->getClientOriginalName();
            $post['image']=request('image')->storeAs('public/images', $filename);
        }
        $post->save();
    
 

        return redirect('/');
    }

    public function show($id){
        $post = Post::find($id); //メインキーを検索
        $comments = Comment::where('post_id', $id)->get();

        //データベースをくっつける
        // $comments['original']
        // = DB::table('comments')
        //             ->join('users','comments.user_id','=','users.id')
        //             ->where('comments.post_id','=',$id)              
        //             ->get(); //全ての取得
    
        // $user = \Auth::user()->id;//ログイン済みかチェック
        // $comments = DB::query()
        // ->select([
        //     'users.name'
        // ])
        // ->from('users')
        // ->leftjoin('posts', function($join) use($user) {
        //     $join->on('users.id', '=', 'posts.user_id')
        //          ->where('posts.user_id', '=', $user);
        // })
        // ->get();

        // $comments = DB::table('comments')
        // ->join('users', 'comments.user_id', '=', 'users.id')
        // ->join('posts', 'comments.post_id', '=', 'posts.id')        
        // ->select('users.name', 'posts.title', 'posts.image')
        // ->first();
        


       $mylists = MyList::where('post_id', $id)->where('user_id', \Auth::user()->id)->get();
        // // dd(count($mylists));
        if(count($mylists) <= 1){
            $mylist = false;
        } else {
            $mylist = $mylists[0]->id;
        }
        



                    // $json = json_encode( $comments );
                    // $decoded_data = json_decode( $json, true );

        return view('posts/show', compact('post','comments','mylist'));
    }

    public function edit($id){
        $post = Post::find($id);
        if(is_null($post)){
            \Session::flash('err_msg','データがありません。');
            return redirect('/');
        }
        return view('posts/edit', compact('post'));
    }

    public function update(Request $request){
        $inputs = $request->all();

        $post = Post::find($inputs['id']);
        $post->fill([
            'title' =>$inputs['title'],
            'body' =>$inputs['body'],
        ]);
        if($post->image){
            $filename=request()->file('image')->getClientOriginalName();
            $post['image']=request('image')->storeAs('public/images', $filename);
        }
        $post->user_id = \Auth::user()->id;
        
        $post->save();
        return redirect('/');
    }
    
    public function delete($id){
        Post::where('id', $id)->delete();
        return redirect('/');
    }
}
