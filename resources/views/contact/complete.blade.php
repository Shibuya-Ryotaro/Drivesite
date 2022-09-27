@php
if(session()->has('request')){
    session()->forget('request');
}
@endphp

@extends('layouts.index')
@section('title', 'cafe-cafe')

@section('css')
<link rel="stylesheet" href="/css/confirm.css">
@endsection

@section('content')
<div class="form_boxs" style="margin: 150px auto">
    <h1>お問い合わせ</h1>
    <div class="form_box">
        <p>
            お問い合わせ頂きありがとうございます。<br>
            送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。<br>
            なお、ご連絡までに、お時間を頂く場合もございますので予めご了承ください。
        </p>
        <a href="/">トップへ戻る</a>
    </div>
</div>
@endsection
