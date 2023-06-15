<?php


namespace Service\Payment\Momo\Models;

use Service\Payment\Momo\Constants\RequestType;

class TransWalletResponse extends WalletResponse
{
    private $refundTrans;
    private $lastUpdated;
    private $resultCode;
    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (array_key_exists($key, $params)) {
                $this->{$key} = $params[$key];
            }
        }

        $this->setRequestType(RequestType::TRANSACTION_STATUS);
    }
    public function setRefundTrans(array $refundTrans)
    {

        return $this->refundTrans = $refundTrans;
    }
    public function getRefundTrans()
    {
        return $this->refundTrans;
    }
    public function setLastUpdated($lastUpdated)
    {
        return $this->lastUpdated = $lastUpdated;
    }
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }
    public function setResultCode($resultCode)
    {
        return $this->resultCode = $resultCode;
    }
    public function getResultCode()
    {
        return $this->resultCode;
    }

}