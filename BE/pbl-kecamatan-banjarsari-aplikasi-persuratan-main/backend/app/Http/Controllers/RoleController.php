<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function indexapi()
    {
        $roles = Role::all();
        return response()->json($roles, 200);
    }

    public function showapi($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role, 200);
    }

    public function storeapi(Request $request)
    {
        $validated = $request->validate([
            'nama_role' => 'required',
        ]);

        $role = new Role;
        $role->nama_role = $request->nama_role;
        $role->save();

        return response()->json($role, 201);
    }

    public function updateapi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_role' => 'required',
        ]);

        $role = Role::findOrFail($id);
        $role->nama_role = $validatedData['nama_role'];
        $role->save();

        return response()->json([
            'message' => 'Role updated successfully',
            'role' => $role,
        ], 200);
    }

    public function destroyapi($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Data role berhasil dihapus.'], 200);
    }
}
