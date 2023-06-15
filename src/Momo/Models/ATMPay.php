<?php


namespace Service\Payment\Momo\Models;

use Service\Payment\Momo\Constants\RequestType;

use Service\Payment\Momo\Models\ApiRequest;

class ATMPay extends ApiRequest
{
    private $bankCode;

    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            if (array_key_exists($key, $params)) {
                $this->{$key} = $params[$key];
            }
        }

        $this->setRequestType(RequestType::PAY_WITH_ATM);

    }

 
    public function getBankCode()
    {
        return $this->bankCode;
    }

    public function setBankCode($bankCode)
    {
        $this->bankCode = $bankCode;
    }

}