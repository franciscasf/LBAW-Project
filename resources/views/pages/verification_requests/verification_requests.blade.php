@extends('layouts.app')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

@section('content')

<style>
    #verificationRequestsDiv {
        display: flex;

        margin: 10px 10%;
    }
</style>

@if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->isModerator()))

    <div id="verificationRequestsDiv">
        <h1>{{$title}}</h1>
    </div>

    <div class="container">
        @if ($verifications->where('status', false)->count() == 0)
            <p>No verification requests available.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Degree</th>
                        <th>School</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($verifications as $verification)
                        <tr>
                            <td>{{ $verification->user->name }}</td>
                            <td>{{ $verification->degree }}</td>
                            <td>{{ $verification->school }}</td>
                            <td
                                <button type="button" class="btn btn-info" onclick="openModal('{{ $verification->user_id }}')">
                                    View ID
                                </button>

                                <div class="modal fade" id="viewIDModal{{ $verification->user_id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="viewIDModalTitle{{ $verification->user_id }}" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewIDModalTitle{{ $verification->user_id }}">ID Picture
                                                </h5>
                                                <button type="button" class="close"
                                                    onclick="closeModal('{{ $verification->user_id }}')" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $verification->id_picture) }}" alt="ID Picture"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function openModal(userId) {
                                        const modal = document.getElementById(`viewIDModal${userId}`);
                                        if (modal) {
                                            modal.style.display = 'block';
                                            modal.classList.add('show');
                                        }
                                    }

                                    
                                    function closeModal(userId) {
                                        const modal = document.getElementById(`viewIDModal${userId}`);
                                        if (modal) {
                                            modal.style.display = 'none';
                                            modal.classList.remove('show');
                                        }
                                    }

                                    
                                    window.addEventListener('click', function (event) {
                                        const modals = document.querySelectorAll('.modal.fade');
                                        modals.forEach(modal => {
                                            if (event.target === modal) {
                                                modal.style.display = 'none';
                                                modal.classList.remove('show');
                                            }
                                        });
                                    });
                                </script>

                                <form action="{{ route('admin.approveVerification', $verification->user_id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                <form action="{{ route('verified_users.destroy', $verification->user_id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@else
    <script>
        window.location.href = "{{ route('home') }}"; 
    </script>
@endif

@endsection