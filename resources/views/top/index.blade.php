@extends('layouts.index')


@section('title','ドライブサイト')



@section('content')
<div id="main_title">
    <h1>ドライブ<br>サイト</h1>
</div>
<ul id="nav_content">


 <a class="btn btn-secondary" href="{{ route('posts.index') }}">投稿一覧</a>

    <a class="btn btn-warning " href="{{ route('mylists.index') }}">マイページ</a>

</ul>

<a href="#" class="jump">
    Jump To Top
</a>
@endsection

@section('js')
<script src="/js/jquery.inview.min.js"></script>
@endsection