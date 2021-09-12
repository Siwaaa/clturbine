@extends('layout')

@section('content')
<div class="p-4 text-center">
    <p class="text-2xl font-medium">Увы. На аккаунте закончились деньги ;(</p>
    <br>
    <p class="text-xs">Вы можете связаться с рекламодателем в <a href="https://instagram.com/{{$page->instagram}}" class="underline">Instagram</a></p>
</div>
@endsection
