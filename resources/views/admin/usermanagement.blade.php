@extends('admin.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <div>
        <h4 class="m-0 pt-1 pb-3 fs-4 accent-color">User Management</h4>
    </div>

    <div class="d-flex justify-content-between mb-1">
        <form action="{{ route('users.index') }}" method="GET">
            <div class="dropdown">
                <button class="btn primary-button dropdown-toggle" type="button" id="role_asDropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter by Roles
                </button>
                <ul class="dropdown-menu" aria-labelledby="role_asDropdown">
                    <li><a class="dropdown-item" href="{{ route('users.index') }}">All</a></li>
                    <li><a class="dropdown-item" href="{{ route('users.index', ['role_as' => 'students']) }}">Students</a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('users.index', ['role_as' => 'admins']) }}">Admins</a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('users.index', ['role_as' => 'teachers']) }}">Teachers</a>
                    </li>
                </ul>
            </div>
        </form>
        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop">
            Add
        </button>
    </div>



    <div class="py-2 card">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-color table-hover table-bg">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Registration number</th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <!-- Display user details -->
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->regNo }}</td>

                            <td>
                                <div class="d-flex justify-content-end">
                                    <!-- Edit button -->
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $user->id }}">Edit
                                        <i class="fa-solid fa-user-pen fa-sm" style="color: #8897b4"></i>
                                    </button>

                                    <!-- Delete button -->
                                    <form class="m-0 p-0" method="POST" action="{{ route('users.destroy', $user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm btn-rounded" type="submit">
                                            Delete
                                        </button>
                                    </form>
                                </div> 
                            </td>

                        </tr>

                        <!-- Edit User Modal -->
                        <div class="modal fade" id="editModal{{ $user->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel{{ $user->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editModalLabel{{ $user->id }}">Edit User</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('users.update', $user->id) }}" method="POST"
                                            class="row g-3 needs-validation" novalidate>
                                            @csrf
                                            @method('PUT')
                                            <div class="col-md-7">
                                                <label for="validationCustom01" class="form-label">Name</label>
                                                <input name="name" type="text"
                                                    value="{{ old('name', $user->name ?? '') }}" class="form-control"
                                                    id="validationCustom01" required>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label"></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="role"
                                                        id="studentRole{{ $user->id }}" value="student"
                                                        {{ old('role', $user->role_as === 0 ? 'checked' : '') }} required>
                                                    <label class="form-check-label" for="studentRole{{ $user->id }}">
                                                        Student
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="role"
                                                        id="adminRole{{ $user->id }}" value="admin"
                                                        {{ old('role', $user->role_as === 1 ? 'checked' : '') }} required>
                                                    <label class="form-check-label" for="adminRole{{ $user->id }}">
                                                        Admin
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="role"
                                                        id="teacherRole{{ $user->id }}" value="teacher"
                                                        {{ old('role', $user->usertype === 2 ? 'checked' : '') }} required>
                                                    <label class="form-check-label" for="teacherRole{{ $user->id }}">
                                                        Teacher
                                                    </label>
                                                </div>
                                                <!-- Rest of the role radio buttons -->
                                            </div>
                                            <div class="col-md-7">
                                                <label for="validationCustom02" class="form-label">Email</label>
                                                <input name="email" type="email"
                                                    value="{{ old('email', $user->email ?? '') }}" class="form-control"
                                                    id="validationCustom02" required>
                                            </div>
                                            <div class="col-md-7">
                                                <label for="validationCustomUsername" class="form-label">Password</label>
                                                <input name="password" type="text" value=""
                                                    class="form-control" id="validationCustomUsername"
                                                    aria-describedby="inputGroupPrepend" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>


    <!--add new User Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST" class="row g-3 needs-validation"
                        novalidate>
                        @csrf
                        <div class="col-md-7">
                            <label for="validationCustom01" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control" id="validationCustom01" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label"></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role_as" id="studentRole"
                                    value="student" required>
                                <label class="form-check-label" for="studentRole">
                                    Student
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role_as" id="adminRole"
                                    value="admin">
                                <label class="form-check-label" for="adminRole">
                                    Admin
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role_as" id="teacherRole"
                                    value="teacher">
                                <label class="form-check-label" for="teacherRole">
                                    Teacher
                                </label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="validationCustom02" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="validationCustom02"
                                value="" required>
                        </div>
                        <div class="col-md-7">
                            <label for="validationCustomUsername" class="form-label">Password</label>
                            <input name="password" type="text" class="form-control" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection