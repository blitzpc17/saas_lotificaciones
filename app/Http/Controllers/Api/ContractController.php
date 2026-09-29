<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Lot;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Contract::with(['customer', 'lot'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'lot_id' => 'required|exists:lots,id',
            'total_amount' => 'required|numeric|min:0',
            'down_payment' => 'required|numeric|min:0',
            'monthly_payment' => 'required|numeric|min:0',
            'total_months' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        $contract = Contract::create($validated);
        
        $lot = Lot::find($validated['lot_id']);
        $lot->status = 'sold';
        $lot->save();

        return response()->json($contract, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        return response()->json($contract->load(['customer', 'lot', 'payments']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'lot_id' => 'required|exists:lots,id',
            'total_amount' => 'required|numeric|min:0',
            'down_payment' => 'required|numeric|min:0',
            'monthly_payment' => 'required|numeric|min:0',
            'total_months' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        $contract->update($validated);
        return response()->json($contract);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();
        return response()->json(['message' => 'Eliminado exitosamente']);
    }
}
