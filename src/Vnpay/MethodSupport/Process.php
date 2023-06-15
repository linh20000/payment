<?php


namespace Service\Payment\Vnpay\MethodSupport;

use Service\Payment\Vnpay\MethodSupport\Environment;

class Process
{
    protected $environment;
    protected $partnerInfo;
    
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
        $this->partnerInfo = $environment->getPartnerInfo();
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

  
    public function getPartnerInfo()
    {
        return $this->partnerInfo;
    }

    
    public function setPartnerInfo($partnerInfo)
    {
        $this->partnerInfo = $partnerInfo;
    }
}