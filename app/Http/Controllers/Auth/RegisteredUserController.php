<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Admin;
use App\Models\Student;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Helpers\Helper;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_as' => ['required', 'in:student,admin,teacher'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $role_asMappings = [
            'student' => 0,
            'admin' => 1,
            'teacher' => 2,
        ];

        //Generate regNo
        if ($request->role_as == 'teacher') {
            $regNo = Helper::NumberIDGenerator('teachers', [], 'TR-', 6);
        } elseif ($request->role_as == 'student') {
            $regNo = Helper::NumberIDGenerator('students', [], 'KU-', 6);
        } elseif ($request->role_as == 'admin') {
            $regNo = Helper::NumberIDGenerator('admins', [], 'AD-', 6);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_as' => $role_asMappings[$request->role_as],
            'regNo' => $regNo,
            'password' => Hash::make($request->password),
            
        ]);
       

        if ($request->role_as == 'teacher')
         {
            //
            Teacher::create([
                'teacher_name' => $request->name,
                'regNo' => $regNo,
            ]);

        } elseif ($request->role_as == 'student')
        
        {   // 
            Student::create([
                'student_name' => $request->name,
                'regNo' => $regNo,
            ]);
        }
        elseif ($request->role_as == 'admin')
        {
            //
            Admin::create([
                'regNo' => $regNo,
                'admin_name' => $request->name,
                
            ]);
        }


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}