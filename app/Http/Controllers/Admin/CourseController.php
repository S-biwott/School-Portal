<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Teacher;
use App\Helpers\Helper;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // how's this used-> $courseType = $request->query('course_type');
        $courses = Courses::all();
        return view('admin.coursemanagement.courses', compact('courses'));
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
    
        $course = new Courses;
        $course->course_id = $request->input('course_id');
        $course->course_name = $request->input('course_name');
        $course->teacher_id = $request->input('regNo');
        $course->course_description = $request->input('course_description');
        $course->save();

        return redirect()->route('courses.index')->with('success', 'Course added successfully.');
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
        $course = Courses::findOrFail($id);
        return view('admin.coursemanagement.edit', compact('course'));
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
        $course = Courses::find($id);

        $course->course_id = $request->input('course_id');
        $course->course_name = $request->input('course_name');
        $course->teacher_id = $request->input('regNo');
        $course->course_description = $request->input('course_description');
        $course->update();

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Courses::find($id);
        //$course = Course::findOrFail($id);
        $course->delete();
    
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}