<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admin;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role_as = $request->query('role_as');

        $users = User::when($role_as, function ($query, $role_as) {
            if ($role_as === 'teachers') {
                return $query->where('role_as', 2);
            } elseif ($role_as === 'students') {
                return $query->where('role_as', 0);
            } elseif ($role_as === 'admins') {
                return $query->where('role_as', 1);
            } else {
                return $query;
            }
        })
            ->get();

        return view('admin.usermanagement', compact('users', 'role_as'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form input
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role_as' => 'required|in:student,teacher,admin',
        ]);

        // Create a new user instance
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $role = $request->input('role_as');
        if ($role === 'student') {
            $user->role_as = 0;
            $user->regNo = Helper::NumberIDGenerator('students', [], 'KU-', 6);
            
        } elseif ($role === 'admin') {
            $user->role_as = 1;
            $user->regNo = Helper::NumberIDGenerator('admins', [], 'AD-', 6);
        } elseif ($role === 'teacher') {
            $user->role_as = 2;
            $user->regNo = Helper::NumberIDGenerator('teachers', [], 'TR-', 6);
        }

        $user->save();

        $role = $request->input('role_as');
        if ($role === 'student') {
            $student = new Student();
            // Populate the student-specific attributes
            $student->regNo = $user->regNo;
            $student->student_name = $user->name;
            
            // Associate the student with the user
            $student->save();
        } elseif ($role === 'teacher') {
            $teacher = new Teacher();
            // Populate the teacher-specific attributes
            $teacher->regNo = $user->regNo;
            $teacher->teacher_name = $user->name;
            // Associate the teacher with the user
            $teacher->save();
        } elseif ($role === 'admin') {
            $admin = new Admin();
            // Populate the admin-specific attributes
            $admin->regNo = $user->regNo; 
            $admin->admin_name = $user->name;
            // Associate the admin with the user
            $admin->save();
        }

        // Redirect to a relevant page or return a response as needed
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }
    public function edit($id)
    {
        // $user = User::find($id);
        // return view('admin.user_edit', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, $id)
    {
        // Find the user
        $user = User::find($id);

        // Validate the form input
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|min:8',
            'role_as' => 'required|in:student,teacher,admin',
        ]);

        // Update the user's information
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $role = $request->input('role_as');
        if ($role === 'student') {
            $user->role_as = 0;
        } elseif ($role === 'admin') {
            $user->role_as = 1;
        } elseif ($role === 'teacher') {
            $user->role_as = 2;
        }

        $user->save();

        // Redirect to a relevant page or return a response as needed
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        //redirect
        return redirect()->route('users.index')->with('success', 'Unit deleted successfully.');
    }
}
