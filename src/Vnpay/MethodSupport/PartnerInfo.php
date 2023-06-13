<?php


namespace Service\Payment\Vnpay\MethodSupport;

class PartnerInfo
{
    private $vnp_TmnCode;
    private $vnp_HashSecret;
    private $vnp_Version;
    public function __construct($vnp_TmnCode,$vnp_HashSecret,$vnp_Version)
    {
        $this->vnp_TmnCode = $vnp_TmnCode;
        $this->vnp_HashSecret = $vnp_HashSecret;
        $this->vnp_Version = $vnp_Version;
    }

    
    public function getHashSecret()
    {
        return $this->vnp_HashSecret;
    }

    
    public function setHashSecret($vnp_HashSecret): void
    {
        $this->vnp_HashSecret = $vnp_HashSecret;
    }

    public function getTmnCode()
    {
        return $this->vnp_TmnCode;
    }

    /**
     * @param mixed $vnp_TmnCode
     */
    public function setTmnCode($vnp_TmnCode): void
    {
        $this->vnp_TmnCode = $vnp_TmnCode;
    }
    public function getVersion()
    {
        return $this->vnp_Version;
    }

    
    public function setVersion($vnp_Version): void
    {
        $this->vnp_Version = $vnp_Version;
    }

}