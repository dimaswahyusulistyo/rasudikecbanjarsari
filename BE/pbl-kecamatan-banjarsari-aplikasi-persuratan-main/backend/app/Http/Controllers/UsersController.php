<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function indexapi(Request $request)
{
    // Determine if the data should be paginated or not
    $paginate = $request->has('paginate') ? filter_var($request->paginate, FILTER_VALIDATE_BOOLEAN) : true;

    // Start the query
    $query = User::query();

    // Handle ordering based on 'input' parameter
    if ($request->has('input')) {
        $order = $request->input('input');
        if ($order === 'az') {
            $query->orderBy('username', 'asc');
        } elseif ($order === 'za') {
            $query->orderBy('username', 'desc');
        }
    } else {
        $query->orderBy('username', 'asc');
    }

    if ($paginate) {
        // If pagination is required
        $perPage = $request->has('per_page') ? intval($request->per_page) : 10;
        $users = $query->paginate($perPage);
        return response()->json([
            'data' => $users->items(),
            'meta' => [
                'last_page' => $users->lastPage(),
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
            ],
        ], 200);
    } else {
        // If no pagination is required
        $users = $query->get();
        return response()->json($users, 200);
    }
}


    public function showapi($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    public function updateapi(Request $request, $id)
    {
        // Validate request data
        $validatedData = $request->validate([
            'username' => 'sometimes|required',
            'id_pegawai' => 'sometimes|required',
            'password' => 'sometimes|required',
            // tambahkan validasi lainnya sesuai kebutuhan
        ]);
    
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Update user data jika ada data yang dikirimkan
        if (isset($validatedData['username'])) {
            $user->username = $validatedData['username'];
        }
        if (isset($validatedData['id_pegawai'])) {
            $user->id_pegawai = $validatedData['id_pegawai'];
        }
        if (isset($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
    
        // Save the updated user
        $user->save();
    
        // Return response
        return response()->json([
            'message' => 'User data updated successfully',
            'user' => $user,
        ], 200);
    }        

    public function destroyapi($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Data Pengguna berhasil dihapus.'], 200);
    }
}
