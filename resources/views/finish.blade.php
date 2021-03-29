@extends('layout')

@section('content')
<user-finish :page-props='@json($page)' :template='@json($template)' />
@endsection
