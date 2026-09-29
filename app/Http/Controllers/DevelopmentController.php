<?php

namespace App\Http\Controllers;

use App\Models\Development;
use Illuminate\Http\Request;

class DevelopmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $developments = Development::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('location', 'like', "%{$search}%");
        })->paginate(10)->withQueryString();

        return view('developments.index', compact('developments', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('developments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'total_lots' => 'required|integer|min:1',
            'amenities' => 'nullable|string',
        ]);

        Development::create($validated);

        return redirect()->route('developments.index')->with('success', 'Desarrollo creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Development $development)
    {
        return view('developments.edit', compact('development'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Development $development)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'total_lots' => 'required|integer|min:1',
            'amenities' => 'nullable|string',
        ]);

        $development->update($validated);

        return redirect()->route('developments.index')->with('success', 'Desarrollo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Development $development)
    {
        $development->delete();

        return redirect()->route('developments.index')->with('success', 'Desarrollo eliminado exitosamente.');
    }
}
