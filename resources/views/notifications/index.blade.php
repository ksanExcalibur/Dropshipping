@extends('layouts.layout') {{-- or your main layout --}}

@section('content')
<div class="container mt-4">
    <h4>All Notifications</h4>
    <ul class="list-group">
        @forelse ($notifications as $notification)
            <li class="list-group-item {{ is_null($notification->read_at) ? 'fw-bold' : 'text-muted' }}">
                {{ $notification->data['message'] ?? 'New Notification' }}
                <br>
                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-sm btn-link">Mark as read</a>
            </li>
        @empty
            <li class="list-group-item">No notifications yet.</li>
        @endforelse
    </ul>

    @if($notifications->isNotEmpty())
        <form action="{{ route('notifications.markAllRead') }}" method="GET">
            <button type="submit" class="btn btn-primary mt-3">Mark All as Read</button>
        </form>
    @endif
</div>
@endsection
