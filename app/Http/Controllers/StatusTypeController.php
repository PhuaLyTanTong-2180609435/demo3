<?php

namespace App\Http\Controllers;

use App\Models\StatusType;
use Illuminate\Http\Request;

class StatusTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $priorityType = StatusType::paginate($perPage);

        return response()->json($priorityType);
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
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'nameStatusType' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timeCreated' => 'nullable|date',
        ]);

        // Tạo mới StatusType
        $statusType = StatusType::create($request->all());

        // Trả về StatusType vừa tạo
        return response()->json($statusType, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Tìm StatusType theo id
        $statusType = StatusType::find($id);

        // Nếu không tìm thấy StatusType, trả về lỗi 404
        if (!$statusType) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        // Trả về StatusType
        return response()->json($statusType, 200);
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
        // Tìm StatusType theo id
        $statusType = StatusType::find($id);

        // Nếu không tìm thấy StatusType, trả về lỗi 404
        if (!$statusType) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        // Xác thực dữ liệu từ client
        $request->validate([
            'nameStatusType' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timeCreated' => 'nullable|date',
        ]);

        // Cập nhật StatusType
        $statusType->update($request->all());

        // Trả về StatusType đã được cập nhật
        return response()->json($statusType, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tìm StatusType theo id
        $statusType = StatusType::find($id);

        // Nếu không tìm thấy StatusType, trả về lỗi 404
        if (!$statusType) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        // Xóa StatusType
        $statusType->delete();

        // Trả về thông báo xóa thành công
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}
