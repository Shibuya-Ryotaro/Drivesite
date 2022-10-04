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
                ★ブックマーク済み
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



      <div id="map" style="height:500px">
      </div>

<!-- 
	{!! Form::open(['route' => 'result.currentLocation','method' => 'get']) !!}
   {{--隠しフォームでresult.currentLocationに位置情報を渡す--}}
   {{--lat用--}}
   {!! Form::hidden('lat','lat',['class'=>'lat_input']) !!}
   {{--lng用--}}
   {!! Form::hidden('lng','lng',['class'=>'lng_input']) !!}
   {{--setlocation.jsを読み込んで、位置情報取得するまで押せないようにdisabledを付与し、非アクティブにする。--}}
   {{--その後、disableはfalseになるようにsetlocation.js内に記述した--}}
   {!! Form::submit("周辺を表示", ['class' => "btn btn-success btn-block",'disabled']) !!}
   {!! Form::close() !!} -->


   <p class="card-text" id="address">{{$post->address}}</p>
   


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

window.onload = function()
{
// ページ読み込み時に実行したい処理
var address = document.getElementById("address").textContent;
getLatLng(address);

};

  // googleMapsAPIを持ってくるときに,callback=initMapと記述しているため、initMap関数を作成
  function initMap(lat,lng,addressInput) {
    map = document.getElementById("map");
    // 東京タワーの緯度は35.6585769,経度は139.7454506と事前に調べておいた
    let address = {
      lat: lat,
      lng: lng
    };
    // オプションを設定
    opt = {
      zoom: 13, //地図の縮尺を指定
      center: address, //センターを東京タワーに指定
    };
    // 地図のインスタンスを作成します。第一引数にはマップを描画する領域、第二引数にはオプションを指定
    mapObj = new google.maps.Map(map, opt);

    marker = new google.maps.Marker({
        // ピンを差す位置を決めます。
        position: address,
	// ピンを差すマップを決めます。
        map: mapObj,
	// ホバーしたときに「tokyotower」と表示されるようにします。
        title: addressInput,
    });

// google map へ表示するための設定
// latlng = new google.maps.LatLng(lat, lng);
//     map = document.getElementById("map");
//     opt = {
//         zoom: 13,
//         center: latlng,
//     };
//     // google map 表示
//     mapObj = new google.maps.Map(map, opt);
//     // マーカーを設定
//     marker = new google.maps.Marker({
//         position: latlng,
//         map: mapObj,
//         title: '現在地',
//     });

  }

  function setLocation(pos) {

// 緯度・経度を取得
const lat = pos.coords.latitude;
const lng = pos.coords.longitude;
// 定数lat,lng をconsoleに出力
console.log(lat);
console.log(lng);

// welcomeの中からlat_inputのclassを見つけて、そのvalueに、定数latを代入
$(".lat_input").val(lat);
    //welcomeの中からlng_inputのclassを見つけて、そのvalueに、定数lngを代入
    $(".lng_input").val(lng);

   

}

$('.btn').prop('disabled', false)

// エラー時に呼び出される関数
function showErr(err) {
switch (err.code) {
    case 1 :
        alert("位置情報の利用が許可されていません");
        break;
    case 2 :
        alert("デバイスの位置が判定できません");
        break;
    case 3 :
        alert("タイムアウトしました");
        break;
    default :
        alert(err.message);
}
}

// geolocation に対応しているか否かを確認
if ("geolocation" in navigator) {
var opt = {
    "enableHighAccuracy": true,
    "timeout": 10000,
    "maximumAge": 0,
};
navigator.geolocation.getCurrentPosition(setLocation, showErr, opt);
} else {
alert("ブラウザが位置情報取得に対応していません");
}
  

  function delete_alert(e) {
    if (!window.confirm('本当に削除しますか？')) {
      window.alert('キャンセルされました');
      return false;
    }
    document.deleteform.submit();
  };

  function getLatLng(address) {

// 入力した住所を取得します。
var addressInput = address;

// Google Maps APIのジオコーダを使います。
var geocoder = new google.maps.Geocoder();

// ジオコーダのgeocodeを実行します。
// 第１引数のリクエストパラメータにaddressプロパティを設定します。
// 第２引数はコールバック関数です。取得結果を処理します。
geocoder.geocode(
    {
        address: addressInput
    },
    function (results, status) {

        console.log(results, status)

        var latlng = "";

        if (status == google.maps.GeocoderStatus.OK) {
            // 取得が成功した場合
            // 結果をループして取得します。
            for (var i in results) {
                if (results[i].geometry) {

                    // 緯度を取得します。
                    var lat = results[i].geometry.location.lat();
                    // 経度を取得します。
                    var lng = results[i].geometry.location.lng();

                    // val()メソッドを使ってvalue値を設定できる
                    // idがlat(またはlng)のvalue値に、変数lat(またはlng)を設定する
                    $('#lat').val(lat);
                    $('#lng').val(lng);

                    // そもそも、ループを回して、検索結果にあっているものをiに入れていっているため
                    // 精度の低いものもでてきてしまう。その必要はないから、一回でbreak
                    break;
                }
            }
            initMap(lat,lng,addressInput);
        } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
            alert("住所が見つかりませんでした。");
        } else if (status == google.maps.GeocoderStatus.ERROR) {
            alert("サーバ接続に失敗しました。");
        } else if (status == google.maps.GeocoderStatus.INVALID_REQUEST) {
            alert("リクエストが無効でした。");
        } else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            alert("リクエストの制限回数を超えました。");
        } else if (status == google.maps.GeocoderStatus.REQUEST_DENIED) {
            alert("サービスが使えない状態でした。");
        } else if (status == google.maps.GeocoderStatus.UNKNOWN_ERROR) {
            alert("原因不明のエラーが発生しました。");
        }
    });
}

$('#searchGeo').on('click', getLatLng);
</script>

<script>
            // currentLocation.jsで使用する定数latに、controllerで定義した$latをいれて、currentLocation.jsに渡す
            const lat = { $lat };

            // currentLocation.jsで使用する定数lngに、controllerで定義した$lngをいれて、currentLocation.jsに渡す
            const lng = { $lng };
        </script>


<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyCeXNcPZvwQDEotF7-Qs01zRJxJr79VQC4&callback=initMap" async defer>
</script>


@endsection


