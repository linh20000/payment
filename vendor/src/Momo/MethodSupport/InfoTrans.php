<?php

namespace Service\Payment\Momo\MethodSupport;

use Illuminate\Support\Facades\Config;
use Service\Payment\Momo\Models\ApiResponse;

class InfoTrans extends ApiResponse
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->setRequestId(time()."");
        $this->setOrderId($data['orderId']);
        $this->setAmount($data['amount']);
    }
}