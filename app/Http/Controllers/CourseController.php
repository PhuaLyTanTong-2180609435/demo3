<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Course::all());
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
        $validatedData = $request->validate([
            'idAccount' => 'required|integer',
            'idIndustryType' => 'required|integer',
            'idPriorityType' => 'required|integer',
            'idCopyrightType' => 'required|integer',
            'idStatusType' => 'required|integer',
            'courseName' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $course = Course::create($validatedData);
        return response()->json($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }
        return response()->json($course);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $validatedData = $request->validate([
            'idAccount' => 'integer',
            'idIndustryType' => 'integer',
            'idPriorityType' => 'integer',
            'idCopyrightType' => 'integer',
            'idStatusType' => 'integer',
            'courseName' => 'string',
            'description' => 'nullable|string',
        ]);

        $course->update($validatedData);
        return response()->json($course);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }
}
