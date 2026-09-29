<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Development;
use Illuminate\Http\Request;

class DevelopmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Development::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amenities' => 'nullable|string',
        ]);

        $development = Development::create($validated);
        return response()->json($development, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Development $development)
    {
        return response()->json($development->load('lots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Development $development)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amenities' => 'nullable|string',
        ]);

        $development->update($validated);
        return response()->json($development);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Development $development)
    {
        $development->delete();
        return response()->json(['message' => 'Eliminado exitosamente']);
    }
}
