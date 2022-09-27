@extends('layouts.index')
@section('title', 'cafe-cafe')

@section('css')
<link rel="stylesheet" href="/css/contact.css">
@endsection

@php
if($request->session()->has('request')){
    $request['name'] = $request->session()->get('request.name');
    $request['kana'] = $request->session()->get('request.kana');
    $request['tel'] = $request->session()->get('request.tel');
    $request['email'] = $request->session()->get('request.email');
    $request['body'] = $request->session()->get('request.body');
}
@endphp

@section('content')
<div class="form_boxs">
    <h1>お問い合わせ</h1>
    <div class="form_box">
        <div class="text_border">下記の項目をご記入の上送信ボタンを押してください</div>
        <p id="form_text">
            送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。<br>
            なお、ご連絡までに、お時間を頂く場合もございますので予めご了承ください。<br>
            <span class="red">*</span>は必須項目となります。
        </p>
        <form id="contact_form" action="{{ route('contact.confirm') }}" method="post">
            @csrf
            <div class="form_list">
                <label for="name">名前<span class="red">*</span></label><br>
                <p class="error-message">{{ $errors->first('name') }}</p>
                <input type="text" id="name" name="name" placeholder="山田太郎" value="@if(empty($request['name'])){{old('name')}}@else{{old('name',$request['name'])}}@endif">
            </div>
            <div class="form_list">
                <label for="kana">フリガナ<span class="red">*</span></label><br>
                <p class="error-message">{{ $errors->first('kana') }}</p>
                <input type="text" id="kana" name="kana" placeholder="ヤマダタロウ" value="@if(empty($request['kana'])){{old('kana')}}@else{{old('kana',$request['kana'])}}@endif">
            </div>
            <div class="form_list">
                <label for="tel">電話番号</label><br>
                <p class="error-message">{{ $errors->first('tel') }}</p>
                <input type="text" id="tel" name="tel" placeholder="09012345678" value="@if(empty($request['tel'])){{old('tel')}}@else{{old('tel',$request['tel'])}}@endif">
            </div>
            <div class="form_list">
                <label for="email">メールアドレス<span class="red">*</span></label><br>
                <p class="error-message">{{ $errors->first('email') }}</p>
                <input type="text" id="email" name="email" placeholder="test@test.co.jp" value="@if(empty($request['email'])){{old('email')}}@else{{old('email',$request['email'])}}@endif">
            </div>
            <div class="text_border">お問い合わせ内容をご記入ください<span class="red">*</span></div>
            <p class="error-message">{{ $errors->first('body') }}</p>
            <textarea id="body" name="body">@if(empty($request['body'])){{old('body')}}@else{{old('body',$request['body'])}}@endif</textarea>
            <div class="submit"><button id="contact_button" class="post_button" type="submit">送信</button></div>
        </form>
    </div>
</div>

<table>
    <tr>
        <th>氏名</th>
        <th>フリガナ</th>
        <th>電話番号</th>
        <th>メールアドレス</th>
        <th>問い合わせ内容</th>
        <th></th>
        <th></th>
    </tr>

@foreach ($contacts as $contact)
        <tr>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->kana }}</td>
            <td>{{ $contact->tel }}</td>
            <td>{{ $contact->email }}</td>
            <td style="word-break: break-all;"><?= nl2br($contact['body']) ?></td>
            <td>
                <a href="{{ route('contact.edit',['id'=>$contact->id]) }}">編集</a>
            </td>
            <td>
                <form method="POST" action="{{ route('contact.destroy',['id'=>$contact->id]) }}">
                    @csrf
                    @method('delete')
                    <button class="delete" type="submit">削除</button>
                </form>
            </td>
        </tr>
@endforeach
</table>
@endsection
