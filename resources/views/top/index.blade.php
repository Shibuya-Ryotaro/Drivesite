@extends('layouts.index')

@section('title','ドライブサイト')

@section('content')
<div id="main_title">
    <h1>ドライブ<br>サイト</h1>
</div>
<ul id="nav_content ">
    <div class="container mt-4">
        <div class="row justify-content-center ">
            <div class="btn-group ">
                <button class="btn btn-outline-primary btn-lg m-4"><a class="btn-lg" href="{{ route('posts.index') }}">投稿一覧</a></button>
                <button class="btn btn-outline-primary btn-lg m-4"><a class="btn-lg" href="{{ route('mylists.index') }}">マイページ</a></button>
            </div>
        </div>
    </div>

</ul>

<a href="#" class="jump">
    Jump To Top
</a>
@endsection

@section('js')
<script src="/js/jquery.inview.min.js"></script>
@endsection