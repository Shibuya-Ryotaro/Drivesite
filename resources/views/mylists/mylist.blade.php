@extends('layouts.app')

@section('content')



<p>myページ</p>

<p>おすすめのドライブスポット・施設を投稿し共有しよう！</p>


<div class="col-md-4 mt-5">

  </p>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">
      </h5>



      @foreach($my_lists as $mylist)
      <div class="col-md-4 mt-5">

        <div class="card">

          <img src="{{ Storage::url($mylist->image) }}" width="300%">

          <div class="card-body">
            <h5 class="card-title">

              <a href="{{route('posts.show', $mylist->post_id)}}">{{ $mylist->title }}</a>
              
            </h5>

            <p class="card-text"><small class="text-muted">{{$mylist->name}}</small></p>

            <p class="card-text">

            </p>

          </div>

        </div>

      </div>
      @endforeach

      <p class="card-text">

      </p>

    </div>

  </div>


</div>


@endsection