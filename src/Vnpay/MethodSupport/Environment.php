<?php


namespace Service\Payment\Vnpay\MethodSupport;


class Environment 
{
    private $Endpoint;
    private $partnerInfo;


    public function __construct($Endpoint, $partnerInfo)
    {
        $this->Endpoint = $Endpoint;
        $this->partnerInfo = $partnerInfo;
    }

    public function getEndpoint()
    {
        return $this->Endpoint;
    }

    public function setEndpoint($Endpoint)
    {
        $this->Endpoint = $Endpoint;
    }

    public function getPartnerInfo(): PartnerInfo
    {
        return $this->partnerInfo;
    }

    public function setPartnerInfo($partnerInfo)
    {
        $this->partnerInfo = $partnerInfo;
    }
}