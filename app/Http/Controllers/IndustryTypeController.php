<?php

namespace App\Http\Controllers;

use App\Models\IndustryType;
use Illuminate\Http\Request;

class IndustryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Số lượng phần tử trên mỗi trang (mặc định là 10)
        $industryType = IndustryType::paginate($perPage);

        return response()->json($industryType);
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
            'nameIndustryType' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timeCreated' => 'nullable|date',
        ]);

        $industryType = IndustryType::create($request->all());

        return response()->json($industryType, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $industryType = IndustryType::find($id);
        if (!$industryType) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($industryType, 200);
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
        $industryType = IndustryType::find($id);
        if (!$industryType) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $request->validate([
            'nameIndustryType' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timeCreated' => 'nullable|date',
        ]);

        $industryType->update($request->all());

        return response()->json($industryType, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $industryType = IndustryType::find($id);
        if (!$industryType) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $industryType->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}
