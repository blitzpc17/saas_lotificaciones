<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('penalties:calculate')]
#[Description('Calculate penalties for late installments across all tenants')]
class CalculatePenalties extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting penalty calculations...');
        $tenants = \App\Models\Tenant::all();

        foreach ($tenants as $tenant) {
            $tenant->run(function () {
                $this->info("Processing tenant: " . tenant('id'));
                
                $lateInstallments = \App\Models\Installment::where('status', 'pending')
                    ->where('due_date', '<', now()->toDateString())
                    ->get();

                foreach ($lateInstallments as $installment) {
                    if ($installment->interest_amount == 0) { // Apply only once
                        $penalty = $installment->principal_amount * 0.05; // 5% flat penalty
                        
                        $installment->interest_amount = $penalty;
                        $installment->total_amount = $installment->principal_amount + $penalty;
                        $installment->status = 'late';
                        $installment->save();
                        
                        $this->line("Applied penalty to installment #{$installment->installment_number} of contract {$installment->contract_id}");
                    } else {
                        // Just ensure status is marked late if it's past due
                        if ($installment->status !== 'late') {
                            $installment->status = 'late';
                            $installment->save();
                        }
                    }
                }
            });
        }
        
        $this->info('Penalty calculation completed.');
    }
}
