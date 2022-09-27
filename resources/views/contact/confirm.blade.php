@extends('layouts.index')
@section('title', 'cafe-cafe')

@section('css')
<link rel="stylesheet" href="/css/confirm.css">
@endsection

@section('content')
<div class="form_boxs">
    <h1>お問い合わせ</h1>
    <div class="form_box">
        <p>下記の内容をご確認の上送信ボタンを押してください<br>
            内容を訂正する場合は戻るを押してください。</p>
        <div class="confirm_box">氏名</div>
        <p class="confirm_value">{{ $inputs['name'] }}</p>
        <div class="confirm_box">フリガナ</div>
        <p class="confirm_value">{{ $inputs['kana'] }}</p>
        <div class="confirm_box">電話番号</div>
        <p class="confirm_value">{{ $inputs['tel'] }}</p>
        <div class="confirm_box">メールアドレス</div>
        <p class="confirm_value">{{ $inputs['email'] }}</p>
        <div class="confirm_box">お問い合わせ内容</div>
        <p class="confirm_value">{!! nl2br(e($inputs['body'])) !!}</p>

        <form class="contact-form" method="post" action="{{ route('contact.complete') }}">
            @csrf
            <input type="hidden" name="name" value="{{ $inputs['name'] }}">
            <input type="hidden" name="kana" value="{{ $inputs['kana'] }}">
            <input type="hidden" name="tel" value="{{ $inputs['tel'] }}">
            <input type="hidden" name="email" value="{{ $inputs['email'] }}">
            <input type="hidden" name="body" value="{{ $inputs['body'] }}">
            <div class="submit">
                <button class="post_button" type="submit">送信</button>
            </div>
        </form>

        {{-- バックボタン用値保持フォーム --}}
        <form id="contact-back-form" method="post" action="{{ route('contact.index.back') }}">
            @csrf
            <input type="hidden" name="name" value="{{ $inputs['name'] }}">
            <input type="hidden" name="kana" value="{{ $inputs['kana'] }}">
            <input type="hidden" name="tel" value="{{ $inputs['tel'] }}">
            <input type="hidden" name="email" value="{{ $inputs['email'] }}">
            <input type="hidden" name="body" value="{{ $inputs['body'] }}">
            <button id="back_button" type="submit">戻る</button>
        </form>
    </div>
</div>
@endsection