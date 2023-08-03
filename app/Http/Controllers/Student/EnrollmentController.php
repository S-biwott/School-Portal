<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Courses;
use App\Models\Unit;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function mycourses()
    {
        //
        $name = Auth::user()->name;
        $regNo = Student::where('student_name', $name)->value('regNo'); // get adm.
        $enrollments = Enrollment::where('regNo', $regNo)->get();// pick all enrollments where adm.
        $courseIds = $enrollments->pluck('course_id'); // get courseid all the courses.
        $courses = Courses::whereIn('course_id', $courseIds)->get();// get course from courses table with ref to courseid
        $units = Unit::all();
        return view('student.mycourses', compact('courses', 'units'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enrollments = Enrollment::all();
        $courses = Courses::with('units')->get();
        $units = Unit::all();
        return view('student.enrollment', compact('enrollments', 'units', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'regNo' => 'required',
            'course_id' => 'required',
        ]);

        $enrollments = DB::table('enrollments')
            ->where('regNo', $request->input('regNo'))
            ->where('regNo', $request->input('regNo'))
            ->first();

        // Create a new enrollment
        if (!$enrollments) {
            $enrollments = new Enrollment;
            $enrollments->regNo = $request->input('regNo');
            $enrollments->course_id = $request->input('course_id');
            $enrollments->save();
        }


        return back()->with('success', 'Enrollment added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve the enrollment by ID
        $enrollments = Enrollment::findOrFail($id);

        return view('student.enrollment.edit', compact('enrollment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'regNo' => 'required',
            'course_id' => 'required',
        ]);

        // Retrieve the enrollment by ID
        $enrollments = Enrollment::findOrFail($id);
        $enrollments->regNo = $request->input('regNo');
        $enrollments->course_id = $request->input('course_id');
        $enrollments->save();

        return redirect()->route('enrollment.index')->with('success', 'Enrollment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Retrieve the enrollment by ID and delete it
        $enrollments = Enrollment::findOrFail($id);
        $enrollments->delete();

        return redirect()->route('enrollment.index')->with('success', 'Enrollment deleted successfully.');
    }
}