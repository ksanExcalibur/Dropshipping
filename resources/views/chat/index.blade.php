@extends('layouts.layout')

@section('title', 'Chat with Users')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-body">
            @livewire('chat-component')
        </div>
    </div>
</div>
@endsection