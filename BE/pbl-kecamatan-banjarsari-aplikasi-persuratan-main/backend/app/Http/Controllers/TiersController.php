<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tier;

class TiersController extends Controller
{
    protected $perPage = 10;

    public function indexapi(Request $request)
    {
        $tiers = Tier::with('jabatans')->paginate($this->perPage);
        return response()->json($tiers, 200);
    }

    public function showapi($id)
    {
        $tier = Tier::with('jabatans')->findOrFail($id);
        return response()->json($tier, 200);
    }

    public function storeapi(Request $request)
    {
        $validated = $this->validateRequest($request);
        $tier = Tier::create($validated);
        return response()->json($tier, 201);
    }

    public function updateapi(Request $request, $id)
    {
        $validated = $this->validateRequest($request);
        $tier = Tier::findOrFail($id);
        $tier->update($validated);
        return response()->json($tier, 200);
    }

    public function destroyapi($id)
    {
        $tier = Tier::findOrFail($id);
        $tier->delete();
        return response()->json(['message' => 'Data tier berhasil dihapus.'], 200);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'tier_name' => 'required|string|max:255',
            'tier_level' => 'required|integer'
        ]);
    }
}
