<?php

namespace Service\Payment\Vnpay\Processors;

use Exception;
use Service\Payment\Vnpay\Database\VnpayLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Service\Payment\Vnpay\Sendmail\Notifycation;

class Log
{

    public static function processBacklog($data)
    {
        if (Auth::check() == true) {
            try {
                $user = Auth::user();
                $model = new VnpayLog();
                $model->vnp_Amount = $data['vnp_Amount'];
                $model->vnp_BankCode =  $data['vnp_BankCode'];
                $model->vnp_BankTranNo =  $data['vnp_BankTranNo'];
                $model->vnp_CardType =  $data['vnp_CardType'];
                $model->vnp_OrderInfo =  $data['vnp_OrderInfo'];
                $model->vnp_PayDate =  $data['vnp_PayDate'];
                $model->vnp_ResponseCode =  $data['vnp_ResponseCode'];
                $model->vnp_TmnCode =  $data['vnp_TmnCode'];
                $model->vnp_TransactionNo =  $data['vnp_TransactionNo'];
                $model->vnp_TransactionStatus =  $data['vnp_TransactionStatus'];
                $model->vnp_TxnRef =  $data['vnp_TxnRef'];
                $model->vnp_SecureHash =  $data['vnp_SecureHash'];
                $model->status = 1;
                $model->save();
                if ($user) {
                    $adminEmail = $user->email;
                } else {
                    $adminEmail = 'ngoquanglinh23062000@gmail.com';
                }
                Mail::to($adminEmail)->send(new Notifycation('true'));
            } catch (Exception $e) {
                throw new Exception("logs fail", 1);
                
            }
        }
    }
}