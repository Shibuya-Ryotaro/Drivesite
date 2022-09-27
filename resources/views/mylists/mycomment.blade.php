@extends('layouts.app')

@section('content')



  <p>mycomment</p>

<p>おすすめのドライブスポット・施設を投稿し共有しよう！</p>
 
 <p href="{{ route('mylists.mylist', $post['id']) }}">お気に入り</p>
 <p href="{{ route('mylists.mypost', $post['id']) }}">my投稿</p>
 <p href="{{ route('mylists.mycomment', $post['id']) }}">myコメント</p>
  
@endsection
