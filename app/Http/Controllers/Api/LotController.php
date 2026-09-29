<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Lot::with('development')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'development_id' => 'required|exists:developments,id',
            'block' => 'required|string|max:50',
            'lot_number' => 'required|string|max:50',
            'area' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,reserved,sold',
        ]);

        $lot = Lot::create($validated);
        return response()->json($lot, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lot $lot)
    {
        return response()->json($lot->load('development'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lot $lot)
    {
        $validated = $request->validate([
            'development_id' => 'required|exists:developments,id',
            'block' => 'required|string|max:50',
            'lot_number' => 'required|string|max:50',
            'area' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,reserved,sold',
        ]);

        $lot->update($validated);
        return response()->json($lot);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lot $lot)
    {
        $lot->delete();
        return response()->json(['message' => 'Eliminado exitosamente']);
    }
}
