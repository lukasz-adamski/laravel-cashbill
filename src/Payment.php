<?php

namespace Adams\CashBill;

use Illuminate\Support\Str;
use Adams\CashBill\Exceptions\CashBillException;

/**
 * @property string $title
 * @property double $amount
 * @property string $currency_code
 * @property string $description
 * @property string $data
 * @property string $return_url
 * @property string $negative_return_url
 * @property string $payment_channel
 * @property string $language_code
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $country
 * @property string $city
 * @property string $postcode
 * @property string $street
 * @property string $house
 * @property string $flat
 * @property string $referer
 */
class Payment
{
    /**
     * Fillable attribute mappings for payment instance.
     * 
     * @var array
     */
    protected $fillable = [
        'title' => 'title',
        'amount' => 'amount.value',
        'currency_code' => 'amount.currencyCode',
        'description' => 'description',
        'data' => 'additionalData',
        'return_url' => 'returnUrl',
        'negative_return_url' => 'negativeReturnUrl',
        'payment_channel' => 'paymentChannel',
        'language_code' => 'languageCode',
        'first_name' => 'personalData.firstName',
        'last_name' => 'personalData.surname',
        'email' => 'personalData.email',
        'country' => 'personalData.country',
        'city' => 'personalData.city',
        'postcode' => 'personalData.postcode',
        'street' => 'personalData.street',
        'house' => 'personalData.house',
        'flat' => 'personalData.flat',
        'referer' => 'referer',
        'sign' => 'sign',
    ];

    /**
     * Filled attributes.
     * 
     * @var array
     */
    protected $attributes = [];

    /**
     * Create new object. 
     * 
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /**
     * Get mapped attribute name.
     * 
     * @param string $name
     * @return string
     * @throws CashBillException
     */
    public function getMappedAttribute($name)
    {
        if (array_key_exists($name, $this->fillable)) {
            $name = $this->fillable[$name];
        } elseif (! in_array($name, array_keys($this->fillable))) {
            throw new CashBillException("Unknown attribute [$name]");
        }

        return $name;
    }

    /**
     * Set mapped attribute value.
     * 
     * @param string $name
     * @param mixed $value
     * @return self
     */
    public function setAttribute($name, $value)
    {
        $name = $this->getMappedAttribute($name);

        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Get mapped attribute value.
     * 
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name)
    {
        $name = $this->getMappedAttribute($name);

        return $this->attributes[$name] ?? '';
    }

    /**
     * Set mapped attributes from array.
     * 
     * @param array $attributes
     * @return void
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $name => $value)
        {
            $this->setAttribute($name, $value);
        }
    }

    /**
     * Get attributes with values.
     * 
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get signable attributes.
     * 
     * @return array
     */
    public function getSignableData()
    {
        $payload = '';

        foreach ($this->fillable as $name)
        {
            $payload .= $this->getAttribute($name);
        }

        return $payload;
    }

    /**
     * Check if attribute is set.
     * 
     * @param string $name
     * @return bool
     */
    public function isAttributeSet($name)
    {
        $name = $this->getMappedAttribute($name);

        return array_key_exists($name, $this->attributes);
    }

    /**
     * Fill default attributes.
     * 
     * @param array $attributes
     * @return void
     */
    public function setDefaultAttributes(array $attributes)
    {
        foreach ($attributes as $name => $value)
        {
            if ($this->isAttributeSet($name)) {
                continue;
            }

            $this->setAttribute($name, $value);
        }
    }

    /**
     * Magic function to set instance fillable attributes.
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    /**
     * Magic function to get instance fillable attributes.
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    /**
     * Magic callback handler to provide getters and setters
     * for fillable attributes.
     * 
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws CashBillException
     */
    public function __call($method, array $arguments = [])
    {
        if (! preg_match('/^(?P<type>get|set)(?P<name>\w+)$/', $method, $matches)) {
            throw new CashBillException("Unable to call $method is not valid getter or setter.");
        }

        $name = Str::snake($matches['name']);

        if ('get' == $matches['type']) {
            return $this->getAttribute($name);
        }

        if ('set' == $matches['type']) {
            if (count($arguments) != 1) {
                throw new CashBillException('Invalid argument count passed to setter - excepted 1.');
            }

            $this->setAttribute($name, $arguments[0]);
        }
    }
}