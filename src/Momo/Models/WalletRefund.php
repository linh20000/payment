<?php


namespace Service\Payment\Momo\Models;

use Service\Payment\Momo\Constants\RequestType;
use Service\Payment\Momo\Models\ApiRequest;

class WalletRefund extends ApiRequest
{
    private $transId;

    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            if (array_key_exists($key, $params)) {
                $this->{$key} = $params[$key];
            }
        }

        $this->setRequestType(RequestType::REFUND_MOMO_WALLET);
    }

   
    public function getTransId()
    {
        return $this->transId;
    }

    
    public function setTransId($transId): void
    {
        $this->transId = $transId;
    }

}