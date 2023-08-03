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
            <a href="{{ url('courses') }}" class="nav-link">
            <i class="fas fa-book"></i>
              <p>
                Add Courses
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('usermanagement') }}" class="nav-link">
            <i class="fas fa-award"></i>
              <p>
                User Management
              </p>
            </a>
          </li>
         

          


@endsection

@section('content')
<!-- Control Sidebar -->


@endsection