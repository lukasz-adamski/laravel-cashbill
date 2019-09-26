<?php

namespace Adams\CashBill\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Adams\CashBill\Http\Requests\NotificationRequest;
use Adams\CashBill\PaymentData;

class Event
{
    use Dispatchable;

    /**
     * Payment data assigned to event.
     * 
     * @var PaymentData
     */
    public $payment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PaymentData $payment)
    {
        $this->payment = $payment;
    }
}