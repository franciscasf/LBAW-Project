@extends('layouts.app')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('css/admin-page.css') }}" rel="stylesheet">

</head>
@section('content')

<style>
    #userAdministrationDiv {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 10px 10%;
    }
</style>

@if (auth()->user() && auth()->user()->isAdmin())
    <div id="userAdministrationDiv">
        <h1>{{$title}}</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModalCenter" id="newUserButton">
            New
        </button>
    </div>

    <div class="modal" id="addUserModalCenter" style="display: {{ $errors->any() ? 'block' : 'none' }};">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalCenterTitle">Create New User</h5>
                <button type="button" class="btn-close" aria-label="Close" onclick="closeModal()"></button>
            </div>

            <form action="{{ route('users.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Username</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               placeholder="Enter username" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="name@example.com" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Enter password" required>
                        @error('password')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation" placeholder="Confirm password" required>
                        @error('password_confirmation')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="moderator" {{ old('role') == 'moderator' ? 'selected' : '' }}>Moderator</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('role')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="container">
        @if ($sortedUsers->isEmpty())
            <p>No users available.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sortedUsers as $user)
                        <tr id="userRow">
                            <td >
                                <a href="{{ route('userProfile', $user->user_id) }}">
                                    {{ $user->name }}
                                </a>
                                @if ($user->isVerified())
                                    <i class="fas fa-check-circle" style="color: #8C0000;"></i>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == "Deleted")
                                    {{ "N/A" }}
                                @else
                                    <a href="#" class="role-link" data-bs-toggle="modal"
                                        data-bs-target="#editRoleModal{{ $user->user_id }}">
                                        {{ $user->role }}
                                    </a>
                                @endif
                                <div class="modal fade" id="editRoleModal{{ $user->user_id }}" tabindex="-1"
                                    aria-labelledby="editRoleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editRoleModalCenterTitle">Edit user role</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('user.changeRole', ['id' => $user->user_id]) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="role">Role</label>
                                                        <select class="form-control" id="role" name="role" required>
                                                            <option value="admin" {{ $user->role == 'Admin' ? 'selected' : '' }}
                                                                @if($user->isBlocked()) disabled @endif>Admin
                                                            </option>
                                                            <option value="moderator" {{ $user->role == 'Moderator' ? 'selected' : '' }}>Moderator</option>
                                                            <option value="user" {{ $user->role == 'User' ? 'selected' : '' }}>User
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <label for="verification">Verification Status</label>
                                                        <select class="form-control" id="verification" name="verification" required>
                                                            <option value="verified" {{ $user->isVerified() ? 'selected' : '' }}>
                                                                Verified</option>
                                                            <option value="unverified" {{ !$user->isVerified() ? 'selected' : '' }}>
                                                                Unverified</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Change Role</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->role != "Deleted")
                                    @if($user->role != "Admin")
                                        @if($user->role == "Blocked User" || $user->role == "Blocked Moderator")
                         
                                            <form method="POST" action="{{ route('user.unblock', ['id' => $user->user_id]) }}" style="display:inline;" >
                                                @csrf
                                                @method('DELETE') <!-- Correct HTTP method -->
                                                <button type="submit" class="btn btn-success" id="unblockButton">Unblock</button>
                                            </form>
                                        @else
                                 
                                            <form method="POST" action="{{ route('user.block', ['id' => $user->user_id]) }}"
                                                style="display:inline;">
                                                @csrf
                                                @method('PUT') 
                                                <button type="submit" class="btn btn-danger" id="blockButton">Block</button>
                                            </form>
                                        @endif
                                    @endif

                                  
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal{{ $user->user_id }}" id="editProfileButton">
                                        Edit Profile
                                    </button>

                                 
                                    <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" id="deleteButton">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                   
                        <div class="modal fade" id="editProfileModal{{ $user->user_id }}" tabindex="-1"
                            aria-labelledby="editProfileModalTitle{{ $user->user_id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProfileModalTitle{{ $user->user_id }}">Edit Profile</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('users.update', ['user' => $user->user_id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                      
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name"
                                                    value="{{ $user->first_name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                    value="{{ $user->last_name }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">Username</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $user->name }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $user->email }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description"
                                                    rows="4">{{ $user->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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


<script>
    
    function closeModal() {
        document.getElementById('addUserModalCenter').style.display = 'none';
    }


    document.addEventListener('DOMContentLoaded', function () {
        if ({{ $errors->any() ? 'true' : 'false' }}) {
            document.getElementById('addUserModalCenter').style.display = 'block';
        }
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>