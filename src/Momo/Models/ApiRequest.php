<?php

namespace Service\Payment\Momo\Models;

use Service\Payment\Momo\MethodSupport\Endcode;

class ApiRequest
{
    private $createUrl;
    private $redirectUrl;
    private $notifyUrl;
    private $refundUrl;
    private $ipnUrl;
    
    
    
    private $partnerCode;
    private $accessKey;
    private $secretKey;
    private $requestType;


    private $orderId;
    private $orderInfo;
    private $amount;
    private $extraData;
    private $requestId;
    private $signature;

    public function __construct($params = array())
    {
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (array_key_exists($key, $params)) {
                $this->{$key} = $params[$key];
            }
        }
    }

    public function getCreateUrl()
    {
        return $this->createUrl;
    }
    public function getReturnUrl()
    {
        return $this->redirectUrl;
    }
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }
    public function getRefundUrl()
    {
        return $this->refundUrl;
    }
    public function getIpnUrl()
    {
        return $this->ipnUrl;
    }

    // 


    public function getPartnerCode()
    {
        return $this->partnerCode;
    }
    public function getAccessKey()
    {
        return $this->accessKey;
    }
    public function getSecretKey()
    {
        return $this->secretKey;
    }
    
    public function getRequestType()
    {
        return $this->requestType;
    }

    // 


    public function getOrderId()
    {
        return $this->orderId;
    }
    public function getOrderInfo()
    {
        return $this->orderInfo;
    } 
    public function getAmount()
    {
        return $this->amount;
    }
    public function getExtraData()
    {
        return $this->extraData;
    }
    public function getRequestId()
    {
        return $this->requestId;
    } 
    public function getSignature()
    {
        return $this->signature;
    }

   
   
    // 




    public function setCreateUrl($createUrl)
    {
        return $this->createUrl = $createUrl;
    }
    public function setReturnUrl($redirectUrl)
    {
        return $this->redirectUrl = $redirectUrl;
    }
    public function setNotifyUrl($notifyUrl)
    {
        return $this->notifyUrl = $notifyUrl;
    }
    public function setRefundUrl($refundUrl)
    {
        return $this->refundUrl = $refundUrl;
    }
    public function setIpnUrl($ipnUrl)
    {
        return $this->ipnUrl = $ipnUrl;
    }
    // 

    public function setPartnerCode($partnerCode)
    {
        $this->partnerCode = $partnerCode;
    }
    public function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;
    }
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }
    
    public function setRequestType($requestType)
    {
        $this->requestType = $requestType;
    }

    // 


    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }
    public function setOrderInfo($orderInfo)
    {
        $this->orderInfo = $orderInfo;
    }
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    public function setExtraData($extraData)
    {
        $encryptionKey = config('app.key');
        $extra = Endcode::encrypt($extraData, $encryptionKey);
        $this->extraData = $extra;
    }
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

}