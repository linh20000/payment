<?php


namespace Service\Payment\Momo\Models;

use Service\Payment\Momo\Constants\RequestType;
use Service\Payment\Momo\Models\WalletRefund;

class RefundRequest extends WalletRefund
{
    private $bankCode;

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

    public function getBankCode()
    {
        return $this->bankCode;
    }


    public function setBankCode($bankCode)
    {
        $this->bankCode = $bankCode;
    }


}