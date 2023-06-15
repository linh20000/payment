<?php
namespace Service\Payment\Momo\Constants;

class RequestType
{
    const MOMO_WALLET = "captureWallet";
    const PAY_WITH_ATM = "payWithATM";
    const TRANSACTION_STATUS = "transactionStatus";
    const REFUND_MOMO_WALLET = "refundMoMoWallet";
    const REFUND_ATM = "refundMoMoATM";
    const QUERY_REFUND = "refundStatus";
    const TRANS_TYPE_MOMO_WALLET = "momo_wallet";
}