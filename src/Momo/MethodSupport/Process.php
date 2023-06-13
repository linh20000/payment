<?php


namespace Service\Payment\Momo\MethodSupport;

use Service\Payment\Momo\MethodSupport\Environment;

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

    
    public function setEnvironment($environment): void
    {
        $this->environment = $environment;
    }

  
    public function getPartnerInfo()
    {
        return $this->partnerInfo;
    }

    
    public function setPartnerInfo($partnerInfo): void
    {
        $this->partnerInfo = $partnerInfo;
    }
}