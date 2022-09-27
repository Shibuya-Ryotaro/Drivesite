@extends('layouts.app')

@section('content')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
 
<div class="container">
  <div class="card mx-auto" style="width: 60%;" >
    <div class="card-body">
 
    <h2 class="text-center">{{ $post->title }}</h2>
    <p>{{ $post->name }}</p>
      
    @if ($mylist)
    <form action="{{route('mylists.delete',$mylist)}}" method="POST" class="mb-4" >
    <input type="hidden" name="post_id" value="{{$post->id}}">
    @csrf
 
        <button type="submit">
          ブックマーク解除
        </button>
    </form>
    @else
    <form action="{{route('mylists.store')}}" method="POST" class="mb-4" >
    @csrf
    <input type="hidden" name="post_id" value="{{$post->id}}">
        <button type="submit">
         ブックマーク
        </button>
    </form>

    @endif


      <img class="d-block mx-auto" src="{{ Storage::url($post->image)}}" height ="auto" width="90%"  >         


            <p class="card-text">{{ $post->body }}</p>
      
            <?php if($post->user_id === Auth::user()->id||Auth::user()->role === 0 ){?>
              <div class="d-flex col">
                <a href="{{ route('post.edit',$post['id'] )}}" type="button" class="btn btn-outline-success mx-2"><i class="fas fa-file-download mr-1"></i>データ編集</a>
                <form  method="POST" action="{{ route('post.delete',$post['id'] )}}" >
                    {{ csrf_field() }}
                <button type="submit" class="btn btn-outline-danger" onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt mr-1"></i>データ削除</button>
                </form>
              </div>
            <?php
            }
            ?>
                 
                <div class = "mt-2">

          </div>
         </div>
    </div>     
  </div>
  <form   action="{{ route('comments.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                        <div class="form-group">

        <label for="exampleFormControlTextarea1">おすすめのドライブスポット・施設を投稿し共有しよう！</label>
        </div>

                        <label for="exampleFormControlTextarea1">コメント </label>
                        <input type="hidden" name="id" value="{{ $post->id }}">


                        <input class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment">

                      </div>                      

                      <button type="submit" class="btn btn-primary">送信</button>
                    </form>
                   
                    @foreach($comments as $comment)
                      <div class="col-md-4 mt-5">

</p>
                          <div class="card">


                                <div class="card-body">
                                  <h5 class="card-title">  


                     
                                   
                                  </h5>

                                      <p>{{ $comment->name }}</p>
                                      <p>{{ $comment->comment }}</p>
                                 
                                               
                                               <p class="card-text">
            
                                   </p>

                            </div>
                        
                            </div>

                            <?php if($comment->user_id === Auth::user()->id||Auth::user()->role === 0 ){?>
                    <div class="d-flex col">
                    
                    <form  method="POST" action="{{ route('comments.delete',$comment['id'] )}}" >
                        {{ csrf_field() }}
                     <button type="submit" class="btn btn-outline-danger" onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt mr-1"></i>データ削除</button>
                     <input type="hidden" name="id" value="{{ $post->id }}">
                    </form>
                    </div>
                    <?php
                    }
                    ?>
                       </div>    
                      @endforeach
</div>


<script>
  function delete_alert(e){
   if(!window.confirm('本当に削除しますか？')){
      window.alert('キャンセルされました'); 
      return false;
   }
   document.deleteform.submit();
};

</script>
   
@endsection

