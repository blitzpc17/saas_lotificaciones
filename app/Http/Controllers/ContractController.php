<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Lot;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $contracts = Contract::with(['customer', 'lot'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('customer', function($q) use ($search) {
                                 $q->where('first_name', 'like', "%{$search}%")
                                   ->orWhere('last_name', 'like', "%{$search}%");
                             })
                             ->orWhereHas('lot', function($q) use ($search) {
                                 $q->where('block', 'like', "%{$search}%")
                                   ->orWhere('lot_number', 'like', "%{$search}%");
                             })
                             ->orWhere('status', 'like', "%{$search}%");
            })
            ->paginate(10)->withQueryString();

        $customers = Customer::all();
        $lots = Lot::with('development')->get(); // fetch all for editing existing contracts
        return view('contracts.index', compact('contracts', 'customers', 'lots', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $lots = Lot::where('status', 'available')->with('development')->get();
        return view('contracts.create', compact('customers', 'lots'));
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
        
        // Update lot status to reserved or sold
        $lot = Lot::find($validated['lot_id']);
        $lot->status = 'sold';
        $lot->save();

        // Generate Installments
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        for ($i = 1; $i <= $validated['total_months']; $i++) {
            // First installment is due on the start_date, subsequent ones are exactly N months later
            $dueDate = $startDate->copy()->addMonths($i - 1);
            \App\Models\Installment::create([
                'contract_id' => $contract->id,
                'installment_number' => $i,
                'due_date' => $dueDate,
                'principal_amount' => $validated['monthly_payment'],
                'interest_amount' => 0,
                'total_amount' => $validated['monthly_payment'],
                'paid_amount' => 0,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('contracts.index')->with('success', 'Contrato registrado exitosamente. Se generó su tabla de amortización.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        $contract->load(['customer', 'lot.development', 'installments' => function($q) {
            $q->orderBy('installment_number');
        }]);
        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        $customers = Customer::all();
        // Include the lot currently associated with the contract, plus available ones
        $lots = Lot::where('status', 'available')->orWhere('id', $contract->lot_id)->with('development')->get();
        return view('contracts.edit', compact('contract', 'customers', 'lots'));
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

        // If lot changed, we might need to handle status changes, but for simplicity we just update here
        $contract->update($validated);

        return redirect()->route('contracts.index')->with('success', 'Contrato actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contrato eliminado exitosamente.');
    }
}
