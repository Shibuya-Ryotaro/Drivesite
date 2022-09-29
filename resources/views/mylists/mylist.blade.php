@extends('layouts.app')

@section('content')



<p>myページ</p>

<p>おすすめのドライブスポット・施設を投稿し共有しよう！</p>




</p>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">
    </h5>

    <div class="container">

      <div class="row">

        @foreach($my_lists as $mylist)
        <div class="col-4">
          <div class="mt-5">

            <div class="card">
              <div class="ratio ratio-4x3">
                <img src="{{ Storage::url($mylist->image) }}" width="100%">
              </div>
              <div class="card-body">
                <h5 class="card-title">

                  <a href="{{route('posts.show', $mylist->post_id)}}">{{ $mylist->title }}</a>

                </h5>

                <p class="card-text"><small class="text-muted">投稿者名：{{$mylist->name}}</small></p>

                <p class="card-text">

                </p>

              </div>

            </div>

          </div>
        </div>
        @endforeach
      </div>
    </div>


    <p class="card-text">

    </p>

  </div>

</div>




@endsection