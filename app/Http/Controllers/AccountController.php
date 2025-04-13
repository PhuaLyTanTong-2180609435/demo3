<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Role;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Số lượng phần tử trên mỗi trang (mặc định là 10)
        $accounts = Account::paginate($perPage);

        return response()->json($accounts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'accountName' => 'required|string|max:255|unique:Account',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'description' => 'nullable|string',
            'email' => 'required|email|unique:Account',
            'role_ids' => 'required|array',  // Mảng chứa các ID role
            'role_ids.*' => 'exists:roles,idRole', // Kiểm tra nếu idRole tồn tại trong bảng roles
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']); // Mã hoá mật khẩu

        // Tạo tài khoản mới
        $account = Account::create($validatedData);

        // Gắn vai trò vào tài khoản mới tạo
        $account->roles()->sync($validatedData['role_ids']);

        return response()->json($account->load('roles'), 201); // Trả về tài khoản với các vai trò
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $account = Account::with('roles')->findOrFail($id);
        return response()->json($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $account = Account::findOrFail($id);

        $validatedData = $request->validate([
            'accountName' => 'string|max:255|unique:Account,accountName,' . $account->idAccount,
            'password' => 'nullable|string|min:8',
            'name' => 'string|max:255',
            'birthday' => 'date',
            'description' => 'nullable|string',
            'email' => 'email|unique:Account,email,' . $account->idAccount,
            'role_ids' => 'nullable|array',  // Mảng chứa các ID role (nếu thay đổi vai trò)
            'role_ids.*' => 'exists:roles,idRole', // Kiểm tra nếu idRole tồn tại trong bảng roles
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']); // Mã hoá mật khẩu
        }

        // Cập nhật thông tin tài khoản
        $account->update($validatedData);

        // Nếu có thay đổi vai trò, cập nhật vai trò
        if (isset($validatedData['role_ids'])) {
            $account->roles()->sync($validatedData['role_ids']);
        }

        return response()->json($account->load('roles'));
    }

    /**
     * Update the roles of the specified account.
     */
    public function updateRole(Request $request, string $id)
    {
        $account = Account::findOrFail($id);

        $validatedData = $request->validate([
            'role_ids' => 'required|array',  // Mảng chứa các ID role mới
            'role_ids.*' => 'exists:roles,idRole', // Kiểm tra nếu idRole tồn tại trong bảng roles
        ]);

        // Đồng bộ lại vai trò của tài khoản
        $account->roles()->sync($validatedData['role_ids']);

        return response()->json($account->load('roles')); // Trả về tài khoản với các vai trò mới
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $account = Account::findOrFail($id);
        $account->delete();
        return response()->json(['message' => 'Account deleted successfully']);
    }
}
