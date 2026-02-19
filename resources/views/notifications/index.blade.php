@extends('layouts.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/notifications-page.css') }}">

</head>
@section('content')
<h2>Notificações</h2>

@if($notifications->isEmpty())
    <p>Não tens notificações no momento.</p>
@else
    <ul class="list-group">
        @foreach($notifications as $notification)
            <li
                class="list-group-item d-flex justify-content-between align-items-center @if(!$notification->is_read) font-weight-bold @endif">
                <div>
                    <strong>{{ $notification->message }}</strong><br>
                    @if($notification->question_id)
                        <a href="{{ route('question.show', $notification->question_id) }}">Go to Question</a>
                    @endif

                    <br>
                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                <div class="notification-item">
                    <button class="notification-mark-read btn btn-primary btn-sm {{ $notification->is_read ? 'd-none' : '' }}"
                        data-id="{{ $notification->notification_id }}">
                        Set as read
                    </button>
                    <i class="fas fa-check {{ !$notification->is_read ? 'd-none' : '' }}"></i>
                </div>


                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const markReadButtons = document.querySelectorAll('.notification-mark-read');

                        markReadButtons.forEach(button => {
                            button.addEventListener('click', function (event) {
                                event.stopPropagation();
                                const notificationId = this.getAttribute('data-id');
                                const notificationItem = this.closest('.notification-item');
                                const icon = notificationItem.querySelector('i.fas.fa-check');

                                // Send the request to mark the notification as read
                                fetch(`/notifications/read/${notificationId}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                        
                                            button.classList.remove('btn-primary');
                                            button.classList.add('btn-success', 'disabled');
                                            button.textContent = 'Read';

                                            icon.classList.remove('d-none');
                                            icon.classList.add('text-success');
                                        } else {
                                            console.error(data.message || 'Failed to mark notification as read.');
                                        }
                                    })
                                    .catch(error => console.error('Error:', error));
                            });
                        });
                    });


                </script>
            </li>
        @endforeach
    </ul>
@endif

<button id="mark-all-read" class="btn btn-secondary mt-3">Mark all as read</button>

<script>

    document.querySelectorAll('.notification-mark-read').forEach(button => {
        button.addEventListener('click', () => {
            const notificationId = button.getAttribute('data-id');
            fetch(`/notifications/read/${notificationId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => {
                if (response.ok) {
                    button.closest('li').classList.remove('font-weight-bold');
                }
            });
        });
    });


    document.getElementById('mark-all-read').addEventListener('click', () => {
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => {
            if (response.ok) {
                document.querySelectorAll('.font-weight-bold').forEach(item => {
                    item.classList.remove('font-weight-bold');
                });
            }
        });
    });
</script>
@endsection