@extends('layouts.app')

@section('content')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

<div class="container">
  <div class="card mx-auto" style="width: 80%;">
    <div class="card-body">
      <h2 class="text-center">{{ $post->title }}</h2>
      <p>{{ $post->name }}</p>
      <div class="container">
        <div class="row">
          <div class="col-2">
            @if ($mylist && Auth::user()!=null)
            <form action="{{route('mylists.delete',$mylist)}}" method="POST" class="mb-4">
              <input type="hidden" name="post_id" value="{{$post->id}}">
              @csrf
              <button type="submit" class="btn btn-warning">
                ★ブックマーク解除
              </button>
            </form>
            @elseif(Auth::user()!=null)
            <form action="{{route('mylists.store')}}" method="POST" class="mb-4">
              @csrf
              <input type="hidden" name="post_id" value="{{$post->id}}">
              <button type="submit" class="btn btn-outline-warning">
                ☆ブックマーク
              </button>
            </form>
            @endif
          </div>
          <div class="col-7"></div>
          <div class="col-3">
            ブックマーク数:{{$mylistCount}}
          </div>
        </div>
      </div>


      <img class="d-block mx-auto" src="{{ Storage::url($post->image)}}" height="auto" width="90%">
      <p class="card-text">投稿内容：{{ $post->body }}</p>
      @if (Auth::user()!=null)
      <?php if ($post->user_id === Auth::user()->id || Auth::user()->role === 0) { ?>
        <div class="d-flex col">
          <a href="{{ route('post.edit',$post['id'] )}}" type="button" class="btn btn-outline-success mx-2"><i class="fas fa-file-download mr-1"></i>データ編集</a>
          <form method="POST" action="{{ route('post.delete',$post['id'] )}}">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-outline-danger" onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt mr-1"></i>データ削除</button>
          </form>
        </div>
      <?php
      }
      ?>
      @endif
    </div>
  </div>
  <form action="{{ route('comments.store') }}" method="post">
    {{ csrf_field() }}
    <div class="form-group mt-4">
      <div class="center-block">
        <label for="exampleFormControlTextarea1">おすすめのドライブスポット・施設を投稿し共有しよう！</label>
      </div>
      <label for="exampleFormControlTextarea1">コメント </label>
      <input type="hidden" name="id" value="{{ $post->id }}">
      @if (Auth::user()!=null)
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">送信</button>
    @endif
  </form>

  @foreach($comments as $comment)
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-body">
        <p>投稿者：{{ $comment->name }}</p>
        <p>コメント：{{ $comment->comment }}</p>
        <p>投稿日：{{$comment->created_at}}</p>
      </div>
    </div>
    @if (Auth::user()!=null)
    <?php if ($comment->user_id === Auth::user()->id || Auth::user()->role === 0) { ?>
      <div class="d-flex col">
        <form method="POST" action="{{ route('comments.delete',$comment->id )}}">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-outline-danger" onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt mr-1"></i>データ削除</button>
          <input type="hidden" name="id" value="{{ $post->id }}">
        </form>
      </div>
    <?php
    }
    ?>
    @endif
  </div>
  @endforeach
</div>

<script>
  function delete_alert(e) {
    if (!window.confirm('本当に削除しますか？')) {
      window.alert('キャンセルされました');
      return false;
    }
    document.deleteform.submit();
  };
</script>
@endsection