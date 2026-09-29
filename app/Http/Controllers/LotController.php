<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Development;
use Illuminate\Http\Request;

class LotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $lots = Lot::with('development')
            ->when($search, function ($query, $search) {
                return $query->where('block', 'like', "%{$search}%")
                             ->orWhere('lot_number', 'like', "%{$search}%")
                             ->orWhereHas('development', function($q) use ($search) {
                                 $q->where('name', 'like', "%{$search}%");
                             });
            })
            ->paginate(10)->withQueryString();

        $developments = Development::all();
        return view('lots.index', compact('lots', 'developments', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $developments = Development::all();
        return view('lots.create', compact('developments'));
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

        Lot::create($validated);

        return redirect()->route('lots.index')->with('success', 'Lote registrado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lot $lot)
    {
        $developments = Development::all();
        return view('lots.edit', compact('lot', 'developments'));
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

        return redirect()->route('lots.index')->with('success', 'Lote actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lot $lot)
    {
        $lot->delete();

        return redirect()->route('lots.index')->with('success', 'Lote eliminado exitosamente.');
    }
}
