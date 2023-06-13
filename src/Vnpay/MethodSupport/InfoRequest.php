<?php

namespace Service\Payment\Vnpay\MethodSupport;

use Illuminate\Support\Facades\Config;
use Service\Payment\Vnpay\Models\ApiRequest;
date_default_timezone_set('Asia/Ho_Chi_Minh');

class InfoRequest extends ApiRequest
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+5 minutes',strtotime($startTime)));
        $time = time() . "";
        $this->setCreateDate(date('YmdHis'));
        $this->setAmount($data['amount'] * 100);
        $this->setReturnUrl($data['returnUrl']);
        $this->setCurrCode('VND');
        $this->setIpAddress(request()->ip());
        $this->setLocale('vn');
        $this->setTnxRef($time);
        $this->setOrderInfo("Thanh toan GD:" . $this->getTxnRef());
        $this->setOrderType('billpayment');
        $this->setCommand('pay');
        $this->setExpiDate($expire);
        $this->setBankCode('VNPAYQR');
    }
}