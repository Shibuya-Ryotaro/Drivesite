@extends('layouts.index')
@section('title', 'cafe-cafe')

@section('css')
<link rel="stylesheet" href="/css/contact.css">
@endsection

@section('content')
<div class="form_boxs">
    <h1>お問い合わせ 編集画面</h1>
    <div class="form_box">
        <div class="text_border">下記の項目を修正の上編集ボタンを押してください</div>
        <form id="contact_form" action="{{ route('contact.update',['id'=>$contact->id]) }}" method="post">
            @csrf
            <div class="form_list">
                <label for="name">名前<span class="red">*</span></label><br>
                <p class="error-message">{{ $errors->first('name') }}</p>
                <input type="text" id="name" name="name" placeholder="山田太郎" value="{{ old('name', $contact['name']) }}">
            </div>
            <div class="form_list">
                <label for="kana">フリガナ<span class="red">*</span></label><br>
                <p class="error-message">{{ $errors->first('kana') }}</p>
                <input type="text" id="kana" name="kana" placeholder="ヤマダタロウ" value="{{ old('kana', $contact['kana']) }}">
            </div>
            <div class="form_list">
                <label for="tel">電話番号</label><br>
                <p class="error-message">{{ $errors->first('tel') }}</p>
                <input type="text" id="tel" name="tel" placeholder="09012345678" value="{{ old('tel', $contact['tel']) }}">
            </div>
            <div class="form_list">
                <label for="email">メールアドレス<span class="red">*</span></label><br>
                <p class="error-message">{{ $errors->first('email') }}</p>
                <input type="text" id="email" name="email" placeholder="test@test.co.jp"value="{{ old('email', $contact['email']) }}">
            </div>
            <div class="text_border">お問い合わせ内容<span class="red">*</span></div>
            <p class="error-message">{{ $errors->first('body') }}</p>
            <textarea id="body" name="body">{{ old('body', $contact['body']) }}</textarea>
            <div class="submit"><button id="contact_button" class="post_button" type="submit">編集</button></div>
        </form>
    </div>
</div>
@endsection
