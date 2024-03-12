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

    protected $payerId;

    protected $payeeId;

    protected $amount;

    protected $reason;

    public function __construct($payerId, $payeeId, $amount, $reason)
    {
        $this->payerId = $payerId;
        $this->payeeId = $payeeId;
        $this->amount = $amount;
        $this->reason = $reason;
    }

    public function handle()
    {

        // Create a new transaction
        Transaction::create([
            'payer_id' => $this->payerId,
            'payee_id' => $this->payeeId,
            'amount' => $this->amount,
            'reason' => $this->reason,
        ]);
    }
}
