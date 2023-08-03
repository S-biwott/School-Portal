@extends('teacher.dashboard')
@section('content')

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
                        <th> ID</th>
                        <th>Unit Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                <!-- display unit details -->
                @foreach ($course->units as $unit)
                    <tr>
                        <td>{{ $unit->unit_id }}</td>
                        <td>{{ $unit->unit_name }}</td>
                        <td>{{ $unit->unit_description }}</td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <!-- Edit button -->
                                <a href="#" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#editBackdrop{{ $unit->unit_id }}">
                                        Edit
                                    </a>
                               
                                 <!-- Delete button -->
                                 <form action="{{ route('units.destroy', $unit->unit_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-rounded" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                                    </form>
                            </div>
                        </td>
                    </tr>

                     <!-- Edit unit Modal -->
                     <div class="modal fade" id="editBackdrop{{ $unit->unit_id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel{{ $unit->unit_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit unit</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <div class="card-body">
                                             <!-- form -->
                                            <form action="{{ route('units.update', $unit->unit_id) }}" method="POST" class="row">
                                                @csrf
                                                @method('PUT')
                                                <div class="col-md-6 mb-3">
                                                    <label for="">ID</label>
                                                    <input type="text" value="{{old('unit_id', $unit->unit_id ?? ' ')}}" class="form-control"  name="unit_id" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="">Unit Name</label>
                                                    <input type="text" value="{{old('unit_name', $unit->unit_name ?? ' ')}}" class="form-control" name="unit_name">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="">Description</label>
                                                    <textarea  type="text" value="{{old('unit_description', $unit->unit_description ?? ' ')}}" class="form-control" name="unit_description" rows="5" required></textarea>
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
    </div>
</div>




<!-- Add Modal -->
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
                        <form action="{{route ('units.store')}}" method="POST" enctype="multi-part/form-data">
                            @csrf
                            <div class="row">
                            <input type="text" class="form-control" value="{{$course->course_id}}" name="course_id" required>
                                <div class="col-md-6 mb-3">
                                    <label for="">ID</label>
                                    <input type="text" class="form-control"  name="unit_id" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Unit Name</label>
                                    <input type="text" class="form-control" name="unit_name">
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="">Description</label>
                                    <textarea name="unit_description" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>        
    @endforeach
@endsection