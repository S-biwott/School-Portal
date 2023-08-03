@extends('teacher.dashboard')
@section('content')
    <!-- Content Header (Page header) -->
<div>
    <h5> Add Marks</h5>
</div>

    @foreach ($courses as $course)
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$course->course_name}}</h4>
         <!-- Button trigger modal -->
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#addBackdrop{{ $course->course_id }}">
                             Add
                        </button>
                    </div>
            </div>
            <div class="card-body">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>STUDENT</th>
                        <th>REGNO</th>
                        <th>UNIT ID</th>
                        <th>CAT 1</th>
                        <th>CAT 2</th>
                        <th>EXAM</th>
                        <th>TOTAL</th>
                        <th>GRADE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($course->units as $unit)
                        @foreach ($marks as $mark)
                            @if ($mark->unit_id == $unit->unit_id && $unit->course_id == $course->course_id)
                                <tr>

                                    @foreach ($users as $user)
                                        @if ($mark->regNo == $user->regNo)
                                            <td>{{ $user->name }}</td>
                                        @endif
                                    @endforeach
                                    <td>{{ $mark->regNo }}</td>
                                    <td>{{ $mark->unit_id }}</td>
                                    <td>{{ $mark->cat1 }}</td>
                                    <td>{{ $mark->cat2 }}</td>
                                    <td>{{ $mark->exam }}</td>
                                    <td>{{ $mark->total_marks }}</td>
                                    <td>{{ $mark->grade }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <!-- Edit button -->
                                            <a href="#" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#editBackdrop{{ $course->course_id }}_{{ $mark->unit_id }}">
                                                Edit
                                            </a>

                                            <!-- Delete button -->
                                            <form class="m-0 p-0" method="POST" action="{{ route('marks.destroy', $mark->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm btn-rounded"
                                                 onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>


                    <!-- Edit mark Modal -->
                    <div class="modal fade" id="editBackdrop{{ $course->course_id }}_{{ $mark->unit_id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel{{ $course->course_id }}_{{ $mark->unit_id }}}"aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Marks</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('marks.update', $mark->id) }}" method="POST" class="row g-3 needs-validation" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-12">
                                            <label for="cat1">CAT 1</label>
                                            <input name="cat1" type="text" value="{{ old('cat1', $mark->cat1) }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="cat2">CAT 2</label>
                                            <input name="cat2" type="text" value="{{ old('cat2', $mark->cat2) }}" class="form-control"  required>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="exam">EXAM</label>
                                            <input name="exam" type="text" value="{{ old('exam', $mark->exam) }}" class="form-control"  required>
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
                </tbody>
                            @endif
                        @endforeach
                    @endforeach
    
                    
            </table>
        </div>
    </div>
</div>


@endforeach


<!-- Add Marks Modal -->
<div class="modal fade" id="addBackdrop{{ $course->course_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <!-- form -->
                        <form action="{{route('marks.store')}}" method="POST" enctype="multi-part/form-data">
                            @csrf
                            <div class="row">
                            <div class="col-md-6">
                                <select class="form-select" aria-label="Default select example" id="select-unit" name="unit_id">
                                    <option selected>Select Unit</option>
                                    @foreach ($course->units as $unit)
                                        <option value="{{ $unit->unit_id }}">{{ $unit->unit_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select mb-2" aria-label="Default select example" id="select-student" name="regNo">
                                    <option selected>Select Student</option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->regNo }}">{{ $student->regNo }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-floating">
                                <input type="text" name="cat1" class="form-control" id="floatingInput1" placeholder=" ">
                                <label for="floatingInput1">CAT 1</label>
                            </div>
                            <div class="col-md-4 form-floating">
                                <input type="text" name="cat2" class="form-control" id="floatingInput2" placeholder=" ">
                                <label for="floatingInput2">CAT 2</label>
                            </div>
                            <div class="col-md-4 form-floating">
                                <input type="text" name="exam" class="form-control" id="floatingInput3" placeholder=" ">
                                <label for="floatingInput3">EXAM</label>
                            </div>
                            <div class="modal-footer col-12 justify-content-between">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>        

@endsection
