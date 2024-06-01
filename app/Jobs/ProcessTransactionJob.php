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
            'order_id' => null,
            'payer_id' => null,
            'payer_type' => 'AEG',
            'payee_id' => null,
            'payee_type' => 'AEG',
            'amount' => 0,
            'currency_type' => null,
            'reason' => null,
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
