<?php


namespace Service\Payment\Momo\MethodSupport;

class PartnerInfo
{
    private $partnerCode;
    private $accessKey;
    private $secretKey;
    public function __construct($partnerCode,$accessKey,  $secretKey)
    {
        $this->partnerCode = $partnerCode;
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
    }

    
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    
    public function setAccessKey($accessKey): void
    {
        $this->accessKey = $accessKey;
    }

    public function getPartnerCode()
    {
        return $this->partnerCode;
    }

    /**
     * @param mixed $partnerCode
     */
    public function setPartnerCode($partnerCode): void
    {
        $this->partnerCode = $partnerCode;
    }

 
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function setSecretKey($secretKey): void
    {
        $this->secretKey = $secretKey;
    }

}