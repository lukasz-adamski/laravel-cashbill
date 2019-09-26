<?php

namespace Adams\CashBill;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Adams\CashBill\Exceptions\ResponseException;

class CashBill
{
    /**
     * Available endpoints.
     */
    const ENDPOINT_LIVE = 'https://pay.cashbill.pl/ws/rest';
    const ENDPOINT_SANDBOX = 'https://pay.cashbill.pl/testws/rest';

    /**
     * Languages supported by provider.
     */
    const LANGUAGE_PL = 'pl';
    const LANGUAGE_EN = 'en';

    /**
     * HTTP client used to work with payment
     * provider API.
     * 
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Create new object instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient([
            'base_uri' => $this->getEndpointUrl()
        ]);
    }

    /**
     * Get current endpoint mode.
     * 
     * @return string
     */
    public function getMode()
    {
        return config('cashbill.mode', 'sandbox');
    }

    /**
     * Get used shop identifier.
     * 
     * @return string
     */
    public function getShopId()
    {
        return config('cashbill.shop_id', '');
    }

    /**
     * Get signing token.
     * 
     * @return string
     */
    public function getToken()
    {
        return config('cashbill.token', '');
    }

    /**
     * Get payment default fields.
     * 
     * @return array
     */
    public function getPaymentDefaults()
    {
        return config('cashbill.payment_defaults', []);
    }

    /**
     * Check if current mode is set to live.
     * 
     * @return bool
     */
    public function isLive()
    {
        return 'live' == $this->getMode();
    }

    /**
     * Check if current mode is set to sandbox.
     * 
     * @return bool
     */
    public function isSandbox()
    {
        return ! $this->isLive();
    }

    /**
     * Get endpoint url.
     * 
     * @return string
     */
    public function getEndpointUrl()
    {
        return $this->isLive() ? self::ENDPOINT_LIVE
            : self::ENDPOINT_SANDBOX;
    }

    /**
     * Get payment channels API uri.
     * 
     * @return string
     */
    public function getPaymentMethodsUri($lang = self::LANGUAGE_PL)
    {
        return 'paymentMethods/' . urlencode($this->getShopId()) . "/$lang";
    }

    /**
     * Get payment API uri.
     * 
     * @return string
     */
    public function getPaymentUri()
    {
        return 'payment/' . urlencode($this->getShopId());
    }

    /**
     * Sign given fields using token.
     * 
     * @param array|string $fields
     * @return string
     */
    public function sign($payload)
    {
        if (is_array($payload)) {
            $payload = join('', $fields);
        }

        return sha1($payload . $this->getToken());
    }

    /**
     * Get payment channels available for shop.
     * 
     * @param string $lang
     * @return array
     */
    public function getPaymentChannels($lang = self::LANGUAGE_PL)
    {
        return $this->request(
            'get', $this->getPaymentMethodsUri($lang)
        );
    }

    /**
     * Prepare payment before API request.
     * 
     * @param Payment
     * @return void
     */
    protected function prepare(Payment $payment)
    {
        $payment->setDefaultAttributes(
            $this->getPaymentDefaults()
        );

        $payment->setSign(
            $this->sign($payment->getSignableData())
        );
    }

    /**
     * Register new payment for shop.
     * 
     * @param array|Payment $payment
     * @return array
     */
    public function register($payment)
    {
        if (is_array($payment)) {
            $payment = new Payment($payment);
        }

        $this->prepare($payment);

        return $this->request(
            'post', $this->getPaymentUri(), $payment->getAttributes()
        );
    }

    /**
     * Register new payment for shop and generate
     * redirect response.
     * 
     * @param array|Payment $fields
     * @return \Illuminate\Http\Response
     */
    public function redirect($payment)
    {
        $payment = $this->register($payment, true);

        return redirect($payment['redirectUrl']);
    }

    /**
     * Get payment data.
     * 
     * @param string $id
     * @return PaymentData
     */
    public function getPayment($id)
    {
        $sign = $this->sign(compact('id'));

        $response = $this->request(
            'get', $this->getPaymentUri() . "/$id", compact('sign')
        );

        return new PaymentData($response);
    }

    /**
     * Send request to API endpoint.
     * 
     * @param string $method
     * @param string $uri 
     * @param array $params
     * @return array
     * @throws ResponseException
     */
    protected function request($method, $uri, array $params = [])
    {
        $response = $this->httpClient->request($method, $uri, [
            ($method == 'post' ? 'form_params' : 'query') => $params 
        ]);

        $content = $response->getBody()->getContent();

        if ($response->getStatusCode() != 200) {
            throw new ResponseException("CashBill error: $content");
        }

        return json_decode($content, true);
    }
}