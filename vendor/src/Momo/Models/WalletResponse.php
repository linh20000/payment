<?php


namespace Service\Payment\Momo\Models;

use Service\Payment\Momo\Constants\RequestType;
use Service\Payment\Momo\Models\ApiResponse;

class WalletResponse extends ApiResponse
{
    private $payUrl;
    private $deeplink;
    private $deeplinkWebInApp;
    private $qrCodeUrl;

    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (array_key_exists($key, $params)) {
                $this->{$key} = $params[$key];
            }
        }

        $this->setRequestType(RequestType::MOMO_WALLET);

    }

   
    public function getPayUrl()
    {
        return $this->payUrl;
    }

    public function setPayUrl($payUrl): void
    {
        $this->payUrl = $payUrl;
    }

    public function getDeeplink()
    {
        return $this->deeplink;
    }

    
    public function setDeeplink($deeplink): void
    {
        $this->deeplink = $deeplink;
    }

    public function getDeeplinkWebInApp()
    {
        return $this->deeplinkWebInApp;
    }

    public function setDeeplinkWebInApp($deeplinkWebInApp): void
    {
        $this->deeplinkWebInApp = $deeplinkWebInApp;
    }

    public function getQrCodeUrl()
    {
        return $this->qrCodeUrl;
    }

   
    public function setQrCodeUrl($qrCodeUrl): void
    {
        $this->qrCodeUrl = $qrCodeUrl;
    }

}
