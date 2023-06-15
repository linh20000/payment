<?php

namespace Service\Payment\Vnpay\Models;

class ApiRequest
{
    private $vnp_Url;
    private $vnp_apiUrl;
    private $apiUrl;

    private $vnp_TmnCode;
    private $vnp_HashSecret;

    private $requestType;

    private $vnp_RequestId;
    private $vnp_Version;
    private $vnp_Command;
    private $vnp_TxnRef;
    private $vnp_Amount;
    private $vnp_CreateDate;
    private $vnp_CurrCode;
    private $vnp_IpAddr;
    private $vnp_Locale;
    private $vnp_OrderInfo;
    private $vnp_ReturnUrl;
    private $vnp_ExpireDate;
    private $vnp_SecureHash;
    private $vnp_OrderType;
    private $vnp_BankCode;


    public function __construct($params = array())
    {
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (array_key_exists($key, $params)) {
                $this->{$key} = $params[$key];
            }
        }
    }
    public function setVnpUrl($vnp_Url)
    {
        return $this->vnp_Url = $vnp_Url;
    }
    public function getVnpUrl()
    {
        return $this->vnp_Url;
    }
    public function setBankCode($vnp_BankCode)
    {
        return $this->vnp_BankCode = $vnp_BankCode;
    }
    public function getBankCode()
    {
        return $this->vnp_BankCode;
    }
    public function setOrderType($vnp_OrderType)
    {
        return $this->vnp_OrderType = $vnp_OrderType;
    }
    public function getOrderType()
    {
        return $this->vnp_OrderType;
    }
    public function setVnpApiUrl($vnp_apiUrl)
    {
        return $this->$vnp_apiUrl = $vnp_apiUrl;
    }
    public function getVnpApiUrl()
    {
        return $this->vnp_apiUrl;
    }
    public function setApiUrl($apiUrl)
    {
        return $this->apiUrl = $apiUrl;
    }
    public function getApiUrl()
    {
        return $this->apiUrl;
    }
    public function setTmnCode($vnp_TmnCode)
    {
        return $this->vnp_TmnCode = $vnp_TmnCode;
    }
    public function getTmnCode()
    {
        return $this->vnp_TmnCode;
    }
    public function setHashSecret($vnp_HashSecret)
    {
        return $this->vnp_HashSecret = $vnp_HashSecret;
    }
    public function getHashSecret()
    {
        return $this->vnp_HashSecret;
    }
    public function setRequestType($requestType)
    {
        return $this->requestType = $requestType;
    }
    public function getRequestType()
    {
        return $this->requestType;
    }
    public function setRequestId($vnp_RequestId)
    {
        $this->vnp_RequestId = $vnp_RequestId;
    }
    public function getRequestId()
    {
        return $this->vnp_RequestId;
    } 
    public function setVersion($vnp_Version)
    {
        $this->vnp_Version = $vnp_Version;
    }
    public function getVersion()
    {
        return $this->vnp_Version;
    }
    public function setCommand($vnp_Command)
    {
        $this->vnp_Command = $vnp_Command;
    }
    public function getCommand()
    {
        return $this->vnp_Command;
    }
    
    public function setTnxRef($vnp_TxnRef)
    {
        $this->vnp_TxnRef = $vnp_TxnRef;
    }
    public function getTxnRef()
    {
        return $this->vnp_TxnRef;
    }
    public function setAmount($vnp_Amount)
    {
        $this->vnp_Amount = $vnp_Amount;
    }
    public function getAmount()
    {
        return $this->vnp_Amount;
    }
    // vnp_CreateDate
    public function setCreateDate($vnp_CreateDate)
    {
        $this->vnp_CreateDate = $vnp_CreateDate;
    }
    public function getCreateDate()
    {
        return $this->vnp_CreateDate;
    }
    // vnp_CurrCode
    public function setCurrCode($vnp_CurrCode)
    {
        $this->vnp_CurrCode = $vnp_CurrCode;
    }
    public function getCurrCode()
    {
        return $this->vnp_CurrCode;
    }
    // vnp_IpAddr
    public function setIpAddress($vnp_IpAddr)
    {
        $this->vnp_IpAddr = $vnp_IpAddr;
    }
    public function getIpAddress()
    {
        return $this->vnp_IpAddr;
    }
    // vnp_Locale
    public function setLocale($vnp_Locale)
    {
        $this->vnp_Locale = $vnp_Locale;
    }
    public function getLocale()
    {
        return $this->vnp_Locale;
    }
    // vnp_OrderInfo
    public function setOrderInfo($vnp_OrderInfo)
    {
        $this->vnp_OrderInfo = $vnp_OrderInfo;
    }
    public function getOrderInfo()
    {
        return $this->vnp_OrderInfo;
    }
    // vnp_ReturnUrl
    public function setReturnUrl($vnp_ReturnUrl)
    {
        $this->vnp_ReturnUrl = $vnp_ReturnUrl;
    }
    public function getReturnUrl()
    {
        return $this->vnp_ReturnUrl;
    }
    // vnp_ExpireDate
    public function setExpiDate($vnp_ExpireDate)
    {
        $this->vnp_ExpireDate = $vnp_ExpireDate;
    }
    public function getExpiDate()
    {
        return $this->vnp_ExpireDate;
    }
    // vnp_SecureHash
    public function setSecureHash($vnp_SecureHash)
    {
        $this->vnp_SecureHash = $vnp_SecureHash;
    }
    public function getSerureHash()
    {
        return $this->vnp_SecureHash;
    }
}