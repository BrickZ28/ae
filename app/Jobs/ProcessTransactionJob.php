<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transactionData;

    public function __construct(array $transactionData = [])
    {
        // Default values
        $defaultValues = [
            'payer_id' => null,
            'payer_type' => 'AfterEarth Gaming',
            'payee_id' => null,
            'amount' => 0,
            'reason' => 'System Payment',
            'order_id' => null,
            'payee_type' => 'AfterEarth Gaming',
            'currency_type' => 'USD',
        ];

        // Merge provided data with default values
        $this->transactionData = array_merge($defaultValues, $transactionData);
    }

    public function handle(): void
    {
       
        // Use the parameters
        Transaction::create($this->transactionData);
    }
}
