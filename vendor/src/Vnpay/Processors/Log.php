<?php

namespace Service\Payment\Vnpay\Processors;

use Exception;
use Service\Payment\Vnpay\Database\VnpayLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Service\Payment\Vnpay\Jobs\SendmailJob;
use Service\Payment\Vnpay\Sendmail\Notifycation;

class Log
{

    public static function processBacklog($inputData)
    {

        if (Auth::check() == true) {
            
            try {
                $user = Auth::user();
                $inputData['userName'] = $user->name;
                $inputData['email'] = $user->email;
                VnpayLog::create($inputData);
                if ($user) {
                    $adminEmail = $user->email;
                } else {
                    $adminEmail = 'ngoquanglinh23062000@gmail.com';
                }
                SendmailJob::dispatch($adminEmail)->delay(now()->addMinutes(2));
            } catch (Exception $e) {
                throw new Exception("logs fail", 1);
                
            }
        }
    }
}