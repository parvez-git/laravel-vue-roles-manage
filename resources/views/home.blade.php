@extends('layouts.app')

@section('content')
<div class="home">
    <home-component :user="{{ auth()->user() }}"></home-component>
</div>
@endsection
