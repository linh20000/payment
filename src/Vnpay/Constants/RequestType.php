<?php

namespace Service\Payment\Vnpay\Constants;

class RequestType
{
    const VNPAY_WALLET = "VNPAYQR";
    const PAY_WITH_ATM = "VNBANK";
    const VNPAY_WALLET_RESPONSE = "transactionStatus";
}