<?php

namespace Service\Payment\Momo\MethodSupport;

use Illuminate\Support\Facades\Config;
use Service\Payment\Momo\Models\ATMRefundRequest;

class InfoRefund extends ATMRefundRequest
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->setRequestId(time()."");
        $this->setOrderId(time()."");
        $this->setAmount($data['amount']);
        $this->setTransId($data['transId']);
    }
}