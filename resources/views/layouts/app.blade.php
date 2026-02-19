<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">


    <!--- BOOTSTRAP FRO MEDAL-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


    <!-- Styles -->
    <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


    <script type="text/javascript">
    </script>
    <script type="text/javascript" src={{ url('js/app.js') }} defer>
    </script>

    <script src="{{ asset('js/notifications-delete.js') }}"></script>
</head>

<body>
    <main>

        <header>
            <h1>
                <a href="{{ url('/') }}">
                    <img src="{{ asset('logo.png') }}" alt="ASK LEIC Logo" class="logo">
                </a>
            </h1>

            <form method="GET" action="{{ route('search') }}" class="search-form">
                <input type="text" name="search" value="{{ request('search') }}" class="search-input"
                    placeholder="Search questions..." aria-label="Search questions">
                <button type="submit" class="search-button" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <div class="header-right">
                @if (Auth::check())
                         
                                <div class="user-dropdown">
                                    <span class="user-icon" onclick="toggleDropdown()">
                                        <i class="fas fa-user"></i>
                                    </span>

                                    <div id="dropdownContent" class="dropdown-content">
                                        <p><strong>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong></p>
                                        <a href="{{ route('userProfile', ['id' => Auth::id()]) }}">My profile</a>
                                        <hr>
                                        <a href="{{ url('/logout') }}" class="logout-link">Logout</a>
                                    </div>
                                </div>


                                <div class="notifications-dropdown">
                                    <span class="notifications-icon" onclick="toggleDropdown('notificationsDropdown')">
                                        <i class="fas fa-bell"></i>
                                        @if(Auth::user()->notifications()->where('is_read', false)->count() > 0)
                                            <span class="badge badge-danger">
                                                {{ Auth::user()->notifications()->where('is_read', false)->count() }}
                                            </span>
                                        @endif
                                    </span>

                                    <div id="notificationsDropdown" class="dropdown-content" style="display: none;">
                                        @php
                                            $notifications = Auth::user()->notifications()
                                                ->with('responder', 'question')
                                                ->orderBy('created_at', 'desc')
                                                ->limit(10)
                                                ->get();
                                        @endphp

                                        @if($notifications->isEmpty())
                                            <p>No notifications.</p>
                                        @else
                                            <ul class="list-group">
                                                @foreach($notifications as $notification)
                                                    @if(!$notification->is_read)
                                                        <li
                                                            class="list-group-item notification-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <a href="{{ route('question.show', ['id' => $notification->question_id]) }}"
                                                                    class="notification-link" data-id="{{ $notification->notification_id }}"
                                                                    style="text-decoration: none; color: inherit;">
                                                                    <strong>
                                                                        @if(str_contains($notification->message, 'vote'))
                                                                            {{ $notification->responder->name ?? 'Unknown User' }} votou na sua pergunta
                                                                            "{{ $notification->question->title ?? 'question' }}"
                                                                        @else
                                                                            {{ $notification->responder->name ?? 'Unknown User' }} respondeu à pergunta
                                                                            "{{ $notification->question->title ?? 'question' }}"
                                                                        @endif
                                                                    </strong>
                                                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                                                </a>
                                                            </div>

                                                            <button class="notification-mark-read btn btn-success btn-sm"
                                                                data-id="{{ $notification->notification_id }}">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </li>

                                                    @endif
                                                @endforeach
                                            </ul>
                                            <div class="text-center mt-2">
                                                <a href="{{ route('notifications.index') }}" class="btn btn-link btn-sm">
                                                    All notifications
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                @else
                    <div class="button-container">
                        <a class="button" href="{{ url('/login') }}">Login</a>
                    </div>
                @endif

        </header>

        <section id="content">
            @yield('content')
        </section>
    </main>
    <footer id="everywhere_footer">
        <ul class="nav-list">
            <li class="nav-item">
                <a class="nav-link" href="/about">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/mainFeatures">Main Features</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/suggestions">Suggestions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/contacts">Contact Us</a>
            </li>
        </ul>
    </footer>

    <script>
        function toggleDropdown(dropdownId) {

            document.querySelectorAll('.dropdown-content').forEach(function (dropdown) {
                dropdown.style.display = 'none';
            });

            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
            }
        }

        window.onclick = function (event) {
            if (!event.target.matches('.user-icon, .notifications-icon, .user-icon *, .notifications-icon *')) {
                document.querySelectorAll('.dropdown-content').forEach(function (dropdown) {
                    dropdown.style.display = 'none';
                });
            }
        };
    </script>


    <script src="{{ url('js/notifications.js') }}"></script>

</body>

</html>