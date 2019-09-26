<?php

namespace Adams\CashBill\Http\Controllers;

use Illuminate\Routing\Controller;
use Adams\CashBill\Events\TransactionStatusChanged;
use Adams\CashBill\Events\VerificationFinished;
use Adams\CashBill\Http\Requests\NotificationRequest;
use Adams\CashBill\Facades\Facade as CashBill;

class WebhookController extends Controller 
{
    /**
     * Handle all incoming transaction notifications
     * from provider.
     * 
     * @param NotificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function handle(NotificationRequest $request)
    {
        abort_if(! $request->checkSignature(), 403, 'Forbidden');

        $payment = CashBill::getPayment(
            $request->getPaymentId()
        );

        if ($request->isStatusChange()) {
            event(new TransactionStatusChanged($payment));
        } elseif ($request->isVerificationFinished()) {
            event(new VerificationFinished($payment));
        }

        return response('OK');
    }
}