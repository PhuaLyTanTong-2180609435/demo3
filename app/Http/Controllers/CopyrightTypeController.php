<?php

namespace App\Http\Controllers;

use App\Models\CopyrightType;
use Illuminate\Http\Request;

class CopyrightTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $copyrightType = CopyrightType::paginate($perPage);

        return response()->json($copyrightType);
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
        $request->validate([
            'nameCopyrightType' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timeCreated' => 'nullable|date',
        ]);

        $copyrightType = CopyrightType::create($request->all());

        return response()->json($copyrightType, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $copyrightType = CopyrightType::find($id);
        if (!$copyrightType) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($copyrightType, 200);
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
        $copyrightType = CopyrightType::find($id);
        if (!$copyrightType) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $request->validate([
            'nameCopyrightType' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timeCreated' => 'nullable|date',
        ]);

        $copyrightType->update($request->all());

        return response()->json($copyrightType, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $copyrightType = CopyrightType::find($id);
        if (!$copyrightType) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $copyrightType->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}
