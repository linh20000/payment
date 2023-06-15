<?php

namespace Service\Payment\Momo\Database;
use Illuminate\Database\Eloquent\Model;
class MomoLog extends Model
{
    protected $fillable = [
       'userId', 'userName','email', 'partnerCode','orderId','requestId','extraData','amount','transId','payType','resultCode','refundTrans','message','responseTime','lastUpdated'
    ];
    protected $table = 'momoLogs';
}