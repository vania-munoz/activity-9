@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

     <h1>Secure Area</h1>

    <p>Welcome, {{auth()->user()->name}}</p>
    <p>This page is protected with auth middleware.</p>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection