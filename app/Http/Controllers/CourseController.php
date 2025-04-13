<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Số lượng phần tử trên mỗi trang (mặc định là 10)
        $courses = Course::paginate($perPage);

        return response()->json($courses);
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

    public function getCourseByAccount($idAccout)
    {
        $account = Account::with('courses')->find($idAccout);

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        return response()->json($account->courses);
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
