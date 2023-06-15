<?php

namespace Service\Payment\Vnpay\Database;
use Illuminate\Database\Eloquent\Model;
class VnpayLog extends Model
{
    protected $table = 'vnpayLogs';
    protected $fillable = [
        'userName','email', 'vnp_Amount', 'vnp_BankCode', 'vnp_BankTranNo', 'vnp_CardType', 'vnp_OrderInfo', 'vnp_PayDate', 'vnp_ResponseCode', 'vnp_TmnCode', 'vnp_TransactionNo', 'vnp_TransactionStatus', 'vnp_TxnRef', 'status'
    ];
    
   
}