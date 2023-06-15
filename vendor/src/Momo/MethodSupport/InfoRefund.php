<?php

namespace Service\Payment\Momo\MethodSupport;

use Illuminate\Support\Facades\Config;
use Service\Payment\Momo\Models\RefundRequest;

class InfoRefund extends RefundRequest
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->setRequestId(time()."");
        $this->setOrderId(time() * 2 ."");
        $this->setAmount($data['amount']);
        $this->setTransId($data['transId']);
    }
}