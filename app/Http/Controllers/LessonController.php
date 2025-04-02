<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Số lượng phần tử trên mỗi trang (mặc định là 10)
        $lesson = Lesson::paginate($perPage);

        return response()->json($lesson);
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
            'idCourse' => 'required|integer',
            'idCopyrightType' => 'required|integer',
            'idStatusType' => 'required|integer',
            'lessonName' => 'required|string|max:255',
            'videoAddress' => 'nullable|string',
            'description' => 'nullable|string',
            'quantityView' => 'integer',
            'quantityComment' => 'integer',
            'quantityFavorite' => 'integer',
            'quantityShared' => 'integer',
            'quantitySaved' => 'integer',
        ]);

        $lesson = Lesson::create($validatedData);
        return response()->json($lesson, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        return response()->json($lesson);
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
        $lesson = Lesson::findOrFail($id);

        $validatedData = $request->validate([
            'idCourse' => 'integer',
            'idCopyrightType' => 'integer',
            'idStatusType' => 'integer',
            'lessonName' => 'string|max:255',
            'videoAddress' => 'nullable|string',
            'description' => 'nullable|string',
            'quantityView' => 'integer',
            'quantityComment' => 'integer',
            'quantityFavorite' => 'integer',
            'quantityShared' => 'integer',
            'quantitySaved' => 'integer',
            'timeCreated' => 'date',
        ]);

        $lesson->update($validatedData);
        return response()->json($lesson);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
