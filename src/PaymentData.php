<?php

namespace Adams\CashBill;

class PaymentData
{
    /**
     * Statuses supported by payment provider.
     */
    const STATUS_PRE_START = 'PreStart';
    const STATUS_START = 'Start';
    const STATUS_ABORT = 'Abort';
    const STATUS_FRAUD = 'Fraud';
    const STATUS_POSITIVE_AUTHORIZATION = 'PositiveAuthorization';
    const STATUS_NEGATIVE_AUTHORIZATION = 'NegativeAuthorization';
    const STATUS_POSITIVE_FINISH = 'PositiveFinish';
    const STATUS_NEGATIVE_FINISH = 'NegativeFinish';
    const STATUS_TIME_EXCEEDED = 'TimeExceeded';
    const STATUS_CRITICAL_ERROR = 'CriticalError';

    /**
     * Attributes data assigned to event.
     * 
     * @var array
     */
    protected $attributes;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Get attributes.
     * 
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get identifier.
     * 
     * @return string
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * Get title.
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->attributes['title'];
    }

    /**
     * Get status.
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->attributes['status'];
    }

    /**
     * Check if status is equal to argument.
     * 
     * @param string $status
     * @return bool
     */
    public function isStatus($status)
    {
        return $status == $this->getStatus();
    }

    /**
     * Check if status is pre start.
     * 
     * @return bool
     */
    public function isPreStart()
    {
        return $this->isStatus(self::STATUS_PRE_START);
    }

    /**
     * Check if status is start.
     * 
     * @return bool
     */
    public function isStart()
    {
        return $this->isStatus(self::STATUS_START);
    }

    /**
     * Check if status is abort.
     * 
     * @return bool
     */
    public function isAbort()
    {
        return $this->isStatus(self::STATUS_ABORT);
    }

    /**
     * Check if status is fraud.
     * 
     * @return bool
     */
    public function isFraud()
    {
        return $this->isStatus(self::STATUS_FRAUD);
    }

    /**
     * Check if status is positive authorization.
     * 
     * @return bool
     */
    public function isPositiveAuthorization()
    {
        return $this->isStatus(self::STATUS_POSITIVE_AUTHORIZATION);
    }

    /**
     * Check if status is negative authorization.
     * 
     * @return bool
     */
    public function isNegativeAuthorization()
    {
        return $this->isStatus(self::STATUS_NEGATIVE_AUTHORIZATION);
    }

    /**
     * Check if status is positive finish.
     * 
     * @return bool
     */
    public function isPositiveFinish()
    {
        return $this->isStatus(self::STATUS_POSITIVE_FINISH);
    }

    /**
     * Check if status is negative finish.
     * 
     * @return bool
     */
    public function isNegativeFinish()
    {
        return $this->isStatus(self::STATUS_NEGATIVE_FINISH);
    }

    /**
     * Check if status is time exceeded.
     * 
     * @return bool
     */
    public function isTimeExceeded()
    {
        return $this->isStatus(self::STATUS_TIME_EXCEEDED);
    }

    /**
     * Check if status is critical error.
     * 
     * @return bool
     */
    public function isCriticalError()
    {
        return $this->isStatus(self::STATUS_CRITICAL_ERROR);
    }

    /**
     * Get channel selected by client.
     * 
     * @return string
     */
    public function getChannel()
    {
        return $this->attributes['paymentChannel'];
    }

    /**
     * Get description.
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->attributes['description'];
    }

    /**
     * Get additional data.
     * 
     * @return
     */
    public function getData()
    {
        return $this->attributes['additionalData'];
    }

    /**
     * Get amount.
     * 
     * @return double
     */
    public function getAmount()
    {
        return $this->attributes['amount']['value'];
    }

    /**
     * Get currency code.
     * 
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->attributes['amount']['currencyCode'];
    }

    /**
     * Get requested amount.
     * 
     * @return double
     */
    public function getRequestedAmount()
    {
        return $this->attributes['requestedAmount']['value'];
    }

    /**
     * Get requested currency code.
     * 
     * @return string
     */
    public function getRequestedCurrencyCode()
    {
        return $this->attributes['requestedAmount']['currencyCode'];
    }

    /**
     * Get first name.
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->attributes['personalData']['firstName'];
    }

    /**
     * Get last name.
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->attributes['personalData']['surname'];
    }

    /**
     * Get email.
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->attributes['personalData']['email'];
    }

    /**
     * Get city.
     * 
     * @return string
     */
    public function getCity()
    {
        return $this->attributes['personalData']['city'];
    }

    /**
     * Get house.
     * 
     * @return string
     */
    public function getHouse()
    {
        return $this->attributes['personalData']['house'];
    }

    /**
     * Get flat.
     * 
     * @return string
     */
    public function getFlat()
    {
        return $this->attributes['personalData']['flat'];
    }

    /**
     * Get street.
     * 
     * @return string
     */
    public function getStreet()
    {
        return $this->attributes['personalData']['street'];
    }

    /**
     * Get postcode.
     * 
     * @return string
     */
    public function getPostcode()
    {
        return $this->attributes['personalData']['postcode'];
    }

    /**
     * Get country.
     * 
     * @return string
     */
    public function getCountry()
    {
        return $this->attributes['personalData']['country'];
    }
}