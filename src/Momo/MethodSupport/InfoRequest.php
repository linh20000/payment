<?php

namespace Service\Payment\Momo\MethodSupport;

use Illuminate\Support\Facades\Config;
use Service\Payment\Momo\Models\ApiRequest;

class InfoRequest extends ApiRequest
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->setRequestId(time()."");
        $this->setOrderId(time()."");
        $this->setAmount($data['amount']);
        $this->setIpnUrl($data['returnUrl']);
        $this->setOrderInfo('Thanh toán qua MOMO');
        $this->setReturnUrl($data['returnUrl']);
        $this->setNotifyUrl(Config::get('notifyUrl'));
        $this->setExtraData($data['data']);
    }
}