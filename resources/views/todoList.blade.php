@extends('layouts.app')
@section('content')
<div class="container">
    <todo-list :user='{{ Auth::user() }}'></todo-list>  
</div>
@endsection