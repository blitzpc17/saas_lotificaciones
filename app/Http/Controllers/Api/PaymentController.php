<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Payment::with('contract')->orderBy('payment_date', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $payment = Payment::create($validated);
        return response()->json($payment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return response()->json($payment->load('contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);
        return response()->json($payment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Eliminado exitosamente']);
    }
}
