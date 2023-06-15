<?php


namespace Service\Payment\Momo\Models;

use Service\Payment\Momo\Constants\RequestType;
use Service\Payment\Momo\Models\ApiRequest;

class RefundStatusRequest extends ApiRequest
{
    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $this->setRequestType(RequestType::QUERY_REFUND);
    }

}