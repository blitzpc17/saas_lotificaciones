<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Contract;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $payments = Payment::with(['contract.customer', 'contract.lot'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('contract.customer', function($q) use ($search) {
                                 $q->where('first_name', 'like', "%{$search}%")
                                   ->orWhere('last_name', 'like', "%{$search}%");
                             })
                             ->orWhereHas('contract.lot', function($q) use ($search) {
                                 $q->where('block', 'like', "%{$search}%")
                                   ->orWhere('lot_number', 'like', "%{$search}%");
                             })
                             ->orWhere('reference', 'like', "%{$search}%")
                             ->orWhere('payment_method', 'like', "%{$search}%");
            })
            ->orderBy('payment_date', 'desc')
            ->paginate(10)->withQueryString();

        $contracts = Contract::with(['customer', 'lot', 'installments' => function($q) {
            $q->whereIn('status', ['pending', 'late'])->orderBy('installment_number');
        }])->where('status', 'active')->get();

        return view('payments.index', compact('payments', 'contracts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contracts = Contract::with(['customer', 'lot', 'installments' => function($q) {
            $q->whereIn('status', ['pending', 'late'])->orderBy('installment_number');
        }])->where('status', 'active')->get();
        return view('payments.create', compact('contracts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'installment_id' => 'required|exists:installments,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $payment = Payment::create($validated);

        // Update installment
        $installment = \App\Models\Installment::find($validated['installment_id']);
        if ($installment) {
            $installment->paid_amount += $validated['amount'];
            if ($installment->paid_amount >= $installment->total_amount) {
                $installment->status = 'paid';
                $installment->paid_date = $validated['payment_date'];
            }
            $installment->save();
        }

        return redirect()->route('payments.index')->with('success', 'Pago registrado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $contracts = Contract::with(['customer', 'lot'])->get();
        return view('payments.edit', compact('payment', 'contracts'));
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

        return redirect()->route('payments.index')->with('success', 'Pago actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Pago eliminado exitosamente.');
    }
}
