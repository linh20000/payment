<?php

namespace Service\Payment\Vnpay\Database;
use Illuminate\Database\Eloquent\Model;
class VnpayLog extends Model
{
    protected $fillable = [];
    protected $table = 'vnpayLogs';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}