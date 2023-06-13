<?php

namespace Service\Payment\Momo\Processors;

use Exception;
use Illuminate\Support\Facades\Config;
use Service\Payment\Momo\MethodSupport\Environment;
use Service\Payment\Momo\MethodSupport\InfoRequest;
use Service\Payment\Momo\MethodSupport\PartnerInfo;
use Service\Payment\Momo\MethodSupport\Process;
use Service\Payment\Momo\Constants\Parameter;
use Service\Payment\Momo\MethodSupport\Endcode;
use Service\Payment\Momo\Constants\RequestType;
use GuzzleHttp\Client;
use Service\Payment\Momo\Models\ATMPay;
use Illuminate\Support\Facades\Auth;
use Service\Payment\Momo\Database\MomoLog;
use Service\Payment\Momo\Sendmail\Notifycation;
use Illuminate\Support\Facades\Mail;
use Service\Payment\Momo\Models\ATMResponse;

class ATM 
{
   protected $payUrl;

    public static function Process(array $data = [])
    {
        $object = new ATM();
        $momoATM = $object->setEnvironment();
        try {
            $momoPay = $object->createCaptureMoMoRequest($data , $momoATM);
            $ATMResponse = $object->execute($momoPay,$momoATM);
            $object->payUrl = $ATMResponse->getPayUrl();
            $payUrl = $object->payUrl;
            return $payUrl;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $object->payUrl;
    }
    
    private function createCaptureMoMoRequest($data , $momoATM): ATMPay
    {
        $info = $this->setInfo($data);
        $info->setRequestType(RequestType::PAY_WITH_ATM);
        $rawData = $this->generateRawHash(
            $momoATM->getPartnerInfo()->getAccessKey(),
            $info->getAmount(),
            $info->getExtraData(),
            $info->getIpnUrl(),
            $info->getOrderId(),
            $info->getOrderInfo(),
            $momoATM->getPartnerInfo()->getPartnerCode(),
            $info->getReturnUrl(),
            $info->getRequestId(),
            $info->getRequestType(),
        );
        $signature = Endcode::hashSha256($rawData, $momoATM->getPartnerInfo()->getSecretKey());
            $arr = array(
                Parameter::PARTNER_CODE => $momoATM->getPartnerInfo()->getPartnerCode(),
                Parameter::ACCESS_KEY => $momoATM->getPartnerInfo()->getAccessKey(),
                Parameter::REQUEST_ID => $info->getRequestId(),
                Parameter::AMOUNT =>  $info->getAmount(),
                Parameter::ORDER_ID => $info->getOrderId(),
                Parameter::ORDER_INFO => $info->getOrderInfo(),
                Parameter::RETURN_URL => $info->getReturnUrl(),
                Parameter::NOTIFY_URL => $info->getReturnUrl(),
                Parameter::EXTRA_DATA => $info->getExtraData(),
                Parameter::SIGNATURE => $signature,
            );
        return new ATMPay($arr);
    }
    private function generateRawHash($accessKey, $amount, $extraData, $ipnUrl, $orderId, $orderInfo, $partnerCode, $redirectUrl, $requestId, $requestType)
    {
        return "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
    }
    public function execute($momoRequest,$momoATM)
    {
        try {
            $data = [
                'partnerCode' => $momoATM->getPartnerInfo()->getPartnerCode(),
                'partnerName' => "Payment momo wallet encryption",
                'storeId' => "Momo wallet storage",
                'requestId' => $momoRequest->getRequestId(),
                'amount' => $momoRequest->getAmount(),
                'orderId' => $momoRequest->getOrderId(),
                'orderInfo' => $momoRequest->getOrderInfo(),
                'redirectUrl' => $momoRequest->getReturnUrl(),
                'ipnUrl' => $momoRequest->getReturnUrl(),
                'lang' => 'vi',
                'extraData' => $momoRequest->getExtraData(),
                'requestType' => $momoRequest->getRequestType(),
                'signature' => $momoRequest->getSignature(),
            ];
            $momoRequest->setSecretKey($momoATM->getPartnerInfo()->getSecretKey());
            $response = $this->initiatePayment($momoATM->getEnvironment()->getMomoEndpoint(), $data);
          
            if ($response->getStatusCode() != 200) {
                throw new \Exception('[CaptureMoMoResponse]-> Error API');
            }
            $result = json_decode($response->getBody(), true);
            return new ATMResponse($result);
        } catch (\Exception $e) {
            throw new \Exception("Error Processing Request", 1);
            
        }
        return $result['payUrl'];
    }
    private function initiatePayment($url, $data)
    {
        $client = new Client();
        $response = $client->post($url, [
            'json' => $data,
            'headers' => [
                'Content-Type' => 'application/json',
                'signature' => $data['signature'],
            ],
        ]);
        return $response;
    }
    private function setInfo($data)
    {
        $info = new InfoRequest($data);
        return $info;
    }
    private function setEnvironment()
    {
        $env = new Environment(Config::get('momo.createUrl'),
                new PartnerInfo(Config::get('momo.partnerCode'), Config::get('momo.accessKey'), Config::get('momo.secretKey')),
                );
        $process = new Process($env);
        return $process;
    }
    public function processBacklog($data)
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
            $adminEmail = $user->email;
            Mail::to($adminEmail)->send(new Notifycation($data['message']));
        } else {
            throw new \Exception("Error Processing Request", 1);
            
        }
    }
}