<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Courses;


class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //unit table belongs to course

    public function index()
    {
        //$courses = Courses::all();    works the same way as the line that follows it

        $name = Auth::user()->name;
        $regNo = Teacher::where('teacher_name', $name)->value('regNo');
        // Assuming you have the teacher user authenticated
        $courses = Courses::where('teacher_id', $regNo)->with('units')->get();
        return view('teacher.units', compact('courses'));
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
      
        $request->validate([
            'course_id' => 'required',
            'unit_id' => 'required',
            'unit_name' => 'required',
            'unit_description' => 'required',
        ]);
    

        $course = Courses::where('course_id', $request['$course_id'])->first();
        
    
        $units = new Unit;
        $units->course_id = $request->input('course_id');
        $units->unit_id = $request->input('unit_id');
        $units->unit_name = $request->input('unit_name');
        $units->unit_description = $request->input('unit_description');
        $units->save();

        return redirect()->route('units.index')->with('success', 'Unit added successfully.');
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
        // $units = Unit::findOrFail($id);
        // return view('teacher.units.edit', compact('units'));
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
        $units = Unit::where('unit_id', $id)->firstOrFail();

        $units->unit_id = $request->input('unit_id');
        $units->unit_name = $request->input('unit_name');
        $units->unit_description = $request->input('unit_description');
        $units->update();

        return redirect()->route('units.index')->with('success', 'Unit updated successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the unit by its ID
        $unit = Unit::where('unit_id', $id)->firstOrFail();

         // Check if the unit exists
         if (!$unit) {
            return redirect()->route('units.index')->with('error', 'Unit not found.');
        }

        // Delete the unit
        $unit->delete();

        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }
}
