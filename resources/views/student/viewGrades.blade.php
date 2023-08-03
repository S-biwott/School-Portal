<!-- resources/views/student/grades.blade.php -->
@extends('student.dashboard')
@section('content')
    <div>
        <h5>Grades</h5>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Unit ID</th>
                        <th>Unit Name</th>
                        <th>TOTAL MARKS</th>
                        <th>GRADE</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($units as $unit)
                    @foreach ($marks as $mark)
                        @if ($mark->unit_id == $unit->unit_id && $mark->regNo == Auth::user()->regNo)
                        <tr>
                            <td>{{ $mark->unit->unit_id }}</td>
                            <td>{{ $mark->unit->unit_name }}</td>
                            <td>{{ $mark->total_marks }}</td>
                            <td>{{ $mark->grade }}</td>

                        </tr>
                        @endif
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
