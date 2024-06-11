<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Http\Response;

class EnrollmentController extends Controller
{
    
    /** add new student and section to database 
     * 
     * @param Request $request
     * @return Response 
    */
    public function add(Request $request)
    {
        Enrollment::create([
            'name' => $request->name,
            'section' => $request->section
        ]);

        return response([
            'message' => "Student added successfully"
        ], 200);
    }

    /**get all students */
    public function get()
    {
        $students = Enrollment::get();

        return response([
             'students' => $students,
             'message' => "Students succ retrieved"
        ], 200);
    }

    /**update table 
     * 
     * @
     * @param Request $request
     * @param ind $id
     * @return response
    */
    public function put(Request $request, int $id)
    {
        $studentInfo = Enrollment::find($id);

        $studentInfo->name = $request->name;
        $studentInfo->section = $request->section;
        $studentInfo->save();

        return response ([
            'message' => "Updated succ"
        ], 200);
    }

    public function delete(int $id)
    {
        $studentInfo = Enrollment::find($id);
        $studentInfo->delete();

        return response([
            'message' => "student is dead"
        ], 200);
    }
}
