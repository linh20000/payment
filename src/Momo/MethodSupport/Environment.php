<?php


namespace Service\Payment\Momo\MethodSupport;


class Environment 
{
    private $momoEndpoint;
    private $partnerInfo;


    public function __construct($momoEndpoint, $partnerInfo)
    {
        $this->momoEndpoint = $momoEndpoint;
        $this->partnerInfo = $partnerInfo;
    }

    public function getMomoEndpoint()
    {
        return $this->momoEndpoint;
    }

    public function setMomoEndpoint($momoEndpoint)
    {
        $this->momoEndpoint = $momoEndpoint;
    }

    public function getPartnerInfo(): PartnerInfo
    {
        return $this->partnerInfo;
    }

    public function setPartnerInfo($partnerInfo): void
    {
        $this->partnerInfo = $partnerInfo;
    }
}