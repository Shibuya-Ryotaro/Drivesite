@extends('layouts.index')
@section('title', 'cafe-cafe')

@section('css')
<link rel="stylesheet" href="/css/contact.css">
@endsection

@section('content')
<div style="margin: 200px 0;">
    <div class="form_boxs">
        <h1>お問い合わせ 編集完了</h1>
        <div class="form_box">
            <p id="form_text">編集が完了しました</p>
            <a href="{{ route('contact.index') }}">お問い合わせ画面へ戻る</a>
        </div>
    </div>
</div>
@endsection
