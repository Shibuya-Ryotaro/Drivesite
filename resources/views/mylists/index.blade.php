@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

  <div class="col-md-4 mt-5">

    <div>myページ</div>

    <div>おすすめのドライブスポット・施設を投稿し共有しよう！</div>

    </p>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
        </h5>
        <p class="index"><a href="{{ route('mylists.mylist') }}">お気に入りへ</a></p>
        <p class="index"><a href="{{ route('mylists.mypost') }}">my投稿</a></p>
        <p class="card-text">

        </p>

      </div>

    </div>
  </div>

</div>

@endsection