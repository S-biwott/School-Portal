<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\Teacher;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Unit;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;



class MarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = Auth::user()->name;
        $regNo = Teacher::where('teacher_name', $name)->value('regNo');
        // Assuming you have the teacher user authenticated
        $courses = Courses::where('teacher_id', $regNo)->with('units')->get();
    
       // Get the course_ids for the courses the teacher is responsible for
       $courseIds = $courses->pluck('course_id')->all();

       // Get the list of students enrolled in the courses the teacher is responsible for
       $students = Enrollment::whereIn('course_id', $courseIds)->with('student')->get();
    
        // Fetch all the marks
        $marks = Mark::all();
        $users = User::all(); 
    
        return view('teacher.marks', compact('marks', 'courses', 'students', 'users'));
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
            'unit_id' => 'required',
            'regNo' => 'required',
            'cat1' => 'nullable',
            'cat2' => 'nullable',
            'exam' => 'nullable',
        ]);

        // Create a new mark
        $mark = new Mark;
        $mark->unit_id = $request->input('unit_id');
        $mark->regNo = $request->input('regNo');
        $mark->cat1 = $request->input('cat1');
        $mark->cat2 = $request->input('cat2');
        $mark->exam = $request->input('exam');
        
        //calculate total
        $cat = ($mark->cat1 + $mark->cat2) / 2;
        $total = $cat + $mark->exam;
        $mark->total_marks = $total;

        //calculate grade
        if ($total >= 70) {
            $mark->grade = 'A';
        } 
        elseif ($total >= 60) {
            $mark->grade = 'B';
        }
        elseif ($total >= 50) {
            $mark->grade = 'C';
        } 
        elseif ($total >= 40) {
            $mark->grade = 'D';
        } 
        else {
            $mark->grade = 'E';
        }
        $mark->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mark = Mark::findOrFail($id);
        return view('teacher.marks', compact('marks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mark = Mark::findOrFail($id);
        return view('teacher.marks', compact('marks'));

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
            'cat1' => 'nullable',
            'cat2' => 'nullable',
            'exam' => 'nullable',
        ]);

        // Retrieve the mark by ID and update 
        $mark = Mark::findOrFail($id);
        $mark->cat1 = $request->input('cat1');
        $mark->cat2 = $request->input('cat2');
        $mark->exam = $request->input('exam');

        //calculate total
        $cat = ($mark->cat1 + $mark->cat2) / 2;
        $total = $cat + $mark->exam;
        $mark->total_marks = $total;

        //calculate grade
        if ($total >= 70) {
            $mark->grade = 'A';
        } elseif ($total >= 60) {
            $mark->grade = 'B';
        } elseif ($total >= 50) {
            $mark->grade = 'C';
        } elseif ($total >= 40) {
            $mark->grade = 'D';
        } else {
            $mark->grade = 'E';
        }
        $mark->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mark = Mark::findOrFail($id);
        $mark->delete();
    
        return redirect()->back()->with('success', 'Mark deleted successfully');
    }
    }
