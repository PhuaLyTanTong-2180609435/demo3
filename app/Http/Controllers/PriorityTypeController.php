<?php

namespace App\Http\Controllers;

use App\Models\PriorityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PriorityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $priorityType = PriorityType::paginate($perPage);

        return response()->json($priorityType);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'namePriorityType' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timeCreated' => 'nullable|date',
        ]);

        $priorityType = PriorityType::create($request->all());

        return response()->json($priorityType, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $priorityType = PriorityType::find($id);
        if (!$priorityType) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($priorityType, 200);
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
        $priorityType = PriorityType::find($id);
        if (!$priorityType) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $request->validate([
            'namePriorityType' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timeCreated' => 'nullable|date',
        ]);

        $priorityType->update($request->all());

        return response()->json($priorityType, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $priorityType = PriorityType::find($id);
        if (!$priorityType) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $priorityType->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}
