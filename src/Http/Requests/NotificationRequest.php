<?php

namespace Adams\CashBill\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Adams\CashBill\Facades\Facade as CashBill;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cmd' => 'required|in:transactionStatusChanged,verificationFinished',
            'args' => 'required',
            'sign' => 'required',
        ];
    }

    /**
     * Check if request notify transaction status change.
     * 
     * @return bool
     */
    public function isStatusChange()
    {
        return 'transactionStatusChanged' == $this->get('cmd');
    }

    /**
     * Check if request notify verification finish.
     * 
     * @return bool
     */
    public function isVerificationFinished()
    {
        return 'verificationFinished' == $this->get('cmd');
    }

    /**
     * Get request arguments.
     * 
     * @return array
     */
    public function getArguments()
    {
        return explode(',', $this->get('args', ''));
    }

    /**
     * Get payment id.
     * 
     * @return string|null
     */
    public function getPaymentId()
    {
        return $this->getAttributes()[0] ?? null;
    }

    /**
     * Check request sign.
     * 
     * @return bool
     */
    public function checkSignature()
    {
        return $this->get('sign') == CashBill::sign(
            $this->only(['cmd', 'args'])
        );
    }
}