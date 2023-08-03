@extends('partial.menu')

@section('sidebar_menu')
<li class="nav-item menu-open">
            <a href="{{ url('dashboard') }}" class="nav-link active">
            <i class="fas fa-book-open"></i>
              <p>
            Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route ('enrollments.index') }}" class="nav-link">
            <i class="fas fa-book"></i>
              <p>
                Course Enrollment
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('/mycourses') }}" class="nav-link">
            <i class="fas fa-award"></i>
              <p>
                My courses
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('grades') }}" class="nav-link">
            <i class="fas fa-award"></i>
              <p>
                Grades
              </p>
            </a>
          </li>

         
          

@endsection