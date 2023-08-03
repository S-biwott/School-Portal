@extends('student.dashboard')
@section('content')

<!-- Content Header (Page header) -->
<div>
    <h4 class="m-0 pt-1 pb-3 fs-4 accent-color">Course Enrollment</h4>
</div>

<!-- Creating Cards for Units -->
<div class="row">
    @foreach ($courses as $course)
        <div class="col-sm-6">
            <div class="card">
                <h5 class="card-header">{{ $course->course_name}} </h5>
                <div class="card-body">
                    <p class="card-text">{{ $course->course_description }}</p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewUnitsModal{{ $course->course_id }}">Enroll</button>
                </div>
            </div>  
        </div>
    @endforeach   
</div> 

<!-- View Units Modal -->
@foreach ($courses as $course)
    <div class="modal fade" id="viewUnitsModal{{ $course->course_id }}" tabindex="-1" role="dialog" aria-labelledby="viewUnitsModalLabel{{ $course->course_id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUnitsModalLabel{{ $course->course_id }}">View Units</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 10px">ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->units as $key => $unit)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $unit->unit_id }}</td>
                                    <td>{{ $unit->unit_name }}</td>
                                    <td>{{ $unit->unit_description }}</td>
                                    <!-- Action dropdown -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('enrollments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="regNo" value="{{ auth()->user()->regNo }}">
                        <input type="hidden" name="course_id" value="{{ $course->course_id }}">
                        <button type="submit" class="btn btn-primary">Enroll</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
