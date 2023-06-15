<?php 

namespace Service\Payment\Momo\Processors;
use Illuminate\Support\Facades\Auth;
use Service\Payment\Momo\Database\MomoLog;
use Illuminate\Support\Facades\Mail;
use Service\Payment\Momo\Jobs\SendmailJob;
use Service\Payment\Momo\Sendmail\Notifycation;

class Log
{
    public function processBacklog($data)
    {
        if (Auth::check() == true) {
            $user = Auth::user();
            $data['userId'] = $user->id;
            $data['userName'] = $user->name;
            $data['email'] = $user->email;
            $data['refundTrans'] = json_encode($data['refundTrans']);
           $mod = MomoLog::create($data);
            if(Auth::check()) {
                $adminEmail = $user->email;

            } else {
                $adminEmail = 'ngoquanglinh23062000@gmail.com';
            }
            SendmailJob::dispatch($adminEmail)->delay(now()->addMinutes(2));
        } else {
            throw new \Exception("Error Processing Request", 1);
            
        }
    }
}