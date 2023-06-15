<?php

namespace Service\Payment\Momo\Processors;

use Exception;
use Illuminate\Support\Facades\Config;
use Service\Payment\Momo\MethodSupport\Environment;
use Service\Payment\Momo\MethodSupport\InfoRequest;
use Service\Payment\Momo\MethodSupport\PartnerInfo;
use Service\Payment\Momo\MethodSupport\Process;
use Service\Payment\Momo\Models\WalletPay;
use Service\Payment\Momo\Constants\Parameter;
use Service\Payment\Momo\MethodSupport\Endcode;
use Service\Payment\Momo\Constants\RequestType;
use GuzzleHttp\Client;
use Service\Payment\Momo\Models\WalletResponse;
use Illuminate\Support\Facades\Mail;
use Service\Payment\Momo\Database\MomoLog;
use Illuminate\Support\Facades\Auth;
use Service\Payment\Momo\Sendmail\Notifycation;

class Wallet 
{
   
    protected $payUrl;

    public static function Process(array $data = [])
    {
        $object = new Wallet();
        $momoWallet = $object->setEnvironment();
        try {
            $momoPay = $object->createCaptureMoMoRequest($data , $momoWallet);
            $captureMoMoResponse = $object->execute($momoPay,$momoWallet);
            return $captureMoMoResponse;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    private function createCaptureMoMoRequest($data , $momoWallet): WalletPay
    {
        $info = $this->setInfo($data);
        $info->setRequestType(RequestType::MOMO_WALLET);
        $rawData = $this->generateRawHash(
            $momoWallet->getPartnerInfo()->getAccessKey(),
            $info->getAmount(),
            $info->getExtraData(),
            $info->getIpnUrl(),
            $info->getOrderId(),
            $info->getOrderInfo(),
            $momoWallet->getPartnerInfo()->getPartnerCode(),
            $info->getReturnUrl(),
            $info->getRequestId(),
            $info->getRequestType(),
        );
        $signature = Endcode::hashSha256($rawData, $momoWallet->getPartnerInfo()->getSecretKey());
            $arr = array(
                Parameter::PARTNER_CODE => $momoWallet->getPartnerInfo()->getPartnerCode(),
                Parameter::ACCESS_KEY => $momoWallet->getPartnerInfo()->getAccessKey(),
                Parameter::REQUEST_ID => $info->getRequestId(),
                Parameter::AMOUNT =>  $info->getAmount(),
                Parameter::ORDER_ID => $info->getOrderId(),
                Parameter::ORDER_INFO => $info->getOrderInfo(),
                Parameter::RETURN_URL => $info->getReturnUrl(),
                Parameter::NOTIFY_URL => $info->getReturnUrl(),
                Parameter::EXTRA_DATA => $info->getExtraData(),
                Parameter::SIGNATURE => $signature,
            );
        return new WalletPay($arr);
    }
    protected function generateRawHash($accessKey, $amount, $extraData, $ipnUrl, $orderId, $orderInfo, $partnerCode, $redirectUrl, $requestId, $requestType)
    {
        return "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
    }
    private function execute($momoRequest,$momoWallet)
    {
        try {
            $data = [
                'partnerCode' => $momoWallet->getPartnerInfo()->getPartnerCode(),
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
            $momoRequest->setSecretKey($momoWallet->getPartnerInfo()->getSecretKey());
            $response = $this->initiatePayment($momoWallet->getEnvironment()->getMomoEndpoint(), $data);
            if ($response->getStatusCode() != 200) {
                throw new \Exception('[CaptureMoMoResponse]-> Error API');
            }
            $result = json_decode($response->getBody(), true);
            return new WalletResponse($result);
        } catch (\Exception $e) {
            throw new \Exception("Error Processing Request", 1);
            
        }
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
   
}