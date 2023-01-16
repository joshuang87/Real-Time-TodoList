@extends('layouts.app')
@section('content')
    <div style="display: flex; align-content:center; justify-content:center;">
        <form action="{{ route('sendEvent') }}">
            <button type="submit">
                <h1>SEND EVENT</h1>
            </button>
        </form>
    </div>
@endsection