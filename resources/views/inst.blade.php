@extends('layout')

@section('content')
<user-inst :page-props='@json($page)' :template='@json($template)' :instinfo='@json($instinfo)' csrf="{{ csrf_token() }}"/>
@endsection
