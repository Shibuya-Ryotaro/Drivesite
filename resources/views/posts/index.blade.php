@extends('layouts.app')

@section('content')



<div class="row justify-content-center">



  <div class="col-md-8">

    <div class="carousel-inner">
      <div class="carousel-item active">
        <!-- <img src="{{ asset('storage/top6.png')}}" class="d-block w-100" alt="..."> -->
      </div>
    </div>


    <div class="container py-4" id="skill">

      <!-- フラッシュメッセージ -->
      @if (session('flash_message'))
      <div class="flash_message alert alert-success" id="flash_message">
        {{ session('flash_message') }}
      </div>
      @endif
      <p>ドライブの最新投稿</p>

      <p>おすすめのドライブスポット・施設を投稿し共有しよう！</p>

      <h2>投稿一覧</h2>


      <div class="progress">
        <div class="progress-bar bg-dark" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div class='newcreate btn btn-outline-primary'><a href="{{ route('posts.create') }}">新規投稿</a></div>

      <div class="card-body">
        <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif      -->
        <div class="card-deck">

          <div class="container">

            <div class="row">
              @foreach($posts as $post)
              <div class="col-4">

                <div class="mt-5">

                  <div class="card">
                    <div class="ratio ratio-4x3">
                      <img src="{{ Storage::url($post->image) }}" class="">
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">
                        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>

                      </h5>
                      <p class="card-text"><small class="text-muted">投稿者：{{ $post->name }}</small></p>
                      <p class="card-text"><small class="text-muted">{{$post->created_at}}</small></p>

                      <p class="card-text">

                      </p>

                    </div>

                  </div>

                </div>

              </div>
              
              @endforeach
              {{ $posts->links() }}
            </div>

          </div>


        </div>
        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  window.setTimeout(() => {
    console.log(document.getElementById('flash-message'));

    $('#flash-message').addClass('d-none');
  }, 3000);
</script>
@endsection