@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ブログ編集</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form enctype="multipart/form-data"  action="{{ route('post.update') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                        <label for="exampleFormControlTextarea1">タイトル</label>
                        <input type="hidden" name="id" value="{{ $post->id }}">


                        <input class="form-control" id="exampleFormControlTextarea1" value="{{ $post->title }}" rows="3" name="title">

                      </div>     
                      <div class="form-group">
                        <label for="exampleFormControlTextarea1">ファイル</label>

                          <div class="form-image_url">
                          <input id= "image" type="file" name="image" accept="image/jpeg,image/png" value="$post['image']" > 
                          </div>
                      </div>          
                      <div class="form-group">                 

                      <div class="form-group">
           
                      
                      </div>
                      <div class="form-group">
                      


                      <label for="exampleFormControlTextarea1">本文</label>
                      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" value="{{ $post->body }}"name="body">{{ $post->body }}</textarea>
                    </div>


                      <button type="submit" class="btn btn-primary">更新する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
