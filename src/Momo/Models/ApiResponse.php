<?php


namespace Service\Payment\Momo\Models;

use Service\Payment\Momo\Models\ApiRequest;

class ApiResponse extends ApiRequest
{
    private $errorCode;
    private $message;
    private $localMessage;
    private $transId;
    private $orderType;
    private $payType;
    private $responseTime;

    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            if (array_key_exists($key, $params)) {
                $this->{$key} = $params[$key];
            }
        }
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function setErrorCode($errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function getLocalMessage()
    {
        return $this->localMessage;
    }

    public function setLocalMessage($localMessage): void
    {
        $this->localMessage = $localMessage;
    }

    public function getTransId()
    {
        return $this->transId;
    }

    public function setTransId($transId): void
    {
        $this->transId = $transId;
    }

    public function getOrderType()
    {
        return $this->orderType;
    }

    public function setOrderType($orderType): void
    {
        $this->orderType = $orderType;
    }

    public function getPayType()
    {
        return $this->payType;
    }

    public function setPayType($payType): void
    {
        $this->payType = $payType;
    }

    public function getResponseTime()
    {
        return $this->responseTime;
    }

    public function setResponseTime($responseTime): void
    {
        $this->responseTime = $responseTime;
    }

}