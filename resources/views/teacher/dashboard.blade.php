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
            <a href="{{ url('units') }}" class="nav-link">
            <i class="fas fa-book"></i>
              <p>
                Add Units
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('marks') }}" class="nav-link">
            <i class="fas fa-award"></i>
              <p>
                Add Marks
              </p>
            </a>
          </li>
         

         

@endsection