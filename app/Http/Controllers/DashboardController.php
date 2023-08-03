<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teacher;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function redirect()
    {
        if (Auth::id()) {
            if (Auth::user()->role_as == '0') {
                return view('student.dashboard');
            } 
            elseif (Auth::user()->role_as == '1') {    
                return view('admin.dashboard');
            } 
            elseif (Auth::user()->role_as == '2') {
                return view('teacher.dashboard');
            }
        }
    }
}
