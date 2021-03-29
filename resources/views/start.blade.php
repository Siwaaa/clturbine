@extends('layout')

@section('content')
<user-start :page-props='@json($page)' :template='@json($template)'/>
@endsection


