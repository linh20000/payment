<?php


namespace Service\Payment\Vnpay\Models;

use Service\Payment\Vnpay\Constants\RequestType;
use Service\Payment\Vnpay\Models\ApiRequest;

class WalletPay extends ApiRequest
{
    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $this->setRequestType(RequestType::VNPAY_WALLET);
    }
}