<?php 

namespace Service\Payment\Momo\Processors;
use Illuminate\Support\Facades\Auth;
use Service\Payment\Momo\Database\MomoLog;
use Illuminate\Support\Facades\Mail;
use Service\Payment\Momo\Sendmail\Notifycation;

class Log
{
    public static function processBacklog($data)
    {
        if (Auth::check() == true) {
            $user = Auth::user();
            $model = new MomoLog();
            $model->userId = $user->id;
            $model->userName = $user->name;
            $model->email = $user->email;
            $model->partnerCode = $data['partnerCode'];
            $model->orderId =  $data['orderId'];
            $model->requestId =  $data['requestId'];
            $model->amount =  $data['amount'];
            $model->orderInfo =  $data['orderInfo'];
            $model->orderType =  $data['orderType'];
            $model->transId =  $data['transId'];
            $model->resultCode =  $data['resultCode'];
            $model->message =  $data['message'];
            $model->payType =  $data['payType'];
            $model->responseTime =  $data['responseTime'];
            $model->signature =  $data['signature'];
            $model->extraData =  $data['extraData'];
            $model->save();
            if(Auth::check()) {
                $adminEmail = $user->email;

            } else {
                $adminEmail = 'ngoquanglinh23062000@gmail.com';
            }
            Mail::to($adminEmail)->send(new Notifycation($data['message']));
        } else {
            throw new \Exception("Error Processing Request", 1);
            
        }
    }
}