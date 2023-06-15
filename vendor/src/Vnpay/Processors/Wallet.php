<?php

namespace Service\Payment\Vnpay\Processors;

use Exception;
use Service\Payment\Vnpay\MethodSupport\Environment;
use Service\Payment\Vnpay\MethodSupport\PartnerInfo;
use Illuminate\Support\Facades\Config;
use Service\Payment\Vnpay\Constants\Parameter;
use Service\Payment\Vnpay\MethodSupport\HttpClient;
use Service\Payment\Vnpay\MethodSupport\Process;
use Service\Payment\Vnpay\Models\ApiRequest;
use Service\Payment\Vnpay\Models\WalletPay;
use Service\Payment\Vnpay\MethodSupport\InfoRequest;

class Wallet extends ApiRequest
{
    public static function Process(array $data)
    {
        $object = new Wallet();
        $wallet = $object->setEnvironment();
        try {
            $request = $object->createWalletVnpayRequest($wallet ,$data);
            $response = $object->execute($wallet , $request);
            return $response;
        } catch (Exception $e) {
            throw new Exception("Error Processing Request vnpay", 1);
            
        }
    }
    private function execute($wallet,$request)
    {
        try {
            $data = array(
                Parameter::VNPAY_VERSION      => $wallet->getpartnerInfo()->getVersion(),
                Parameter::VNPAY_TMNCODE      => $wallet->getpartnerInfo()->getTmnCode(),
                Parameter::AMOUNT             => $request->getAmount(),
                Parameter::VNPAY_COMMAND      => $request->getCommand(),
                Parameter::VNPAY_CREATE_DATE  => $request->getCreateDate(),
                Parameter::VNPAY_CURRENT_CODE => $request->getCurrCode(),
                Parameter::VNPAY_IP_ADDRESS   => $request->getIpAddress(),
                Parameter::VNPAY_LOCALE       => $request->getLocale(),
                Parameter::VNPAY_ORDER_INFO   => $request->getOrderInfo(),
                Parameter::VNPAY_RETURN_URL   => $request->getReturnUrl(),
                Parameter::VNPAY_TXNREF       => $request->getTxnRef(),
                Parameter::VNPAY_ORDER_TYPE   => $request->getOrderType(),
                Parameter::VNPAY_EXPIRE_DATE  => $request->getExpiDate(),
                Parameter::VNPAY_BANK_CODE    => $request->getBankCode(),
            );
            $response = HttpClient::HTTPPost($data,$wallet->getEnvironment()->getEndpoint(), $wallet->getEnvironment()->getPartnerInfo()->getHashSecret());       
            return $response;
        } catch (\Exception $e) {
            throw new \Exception("Error Processing Request" + $e->getMessage(), 1);
            
        }
    }
    private function createWalletVnpayRequest($wallet , $data): WalletPay
    {
        $info = $this->setInfo($data);
       
        $arr = [
            Parameter::VNPAY_VERSION      => $wallet->getpartnerInfo()->getVersion(),
            Parameter::VNPAY_TMNCODE      => $wallet->getpartnerInfo()->getTmnCode(),
            Parameter::AMOUNT             => $info->getAmount(),
            Parameter::VNPAY_COMMAND      => $info->getCommand(),
            Parameter::VNPAY_CREATE_DATE  => $info->getCreateDate(),
            Parameter::VNPAY_CURRENT_CODE => $info->getCurrCode(),
            Parameter::VNPAY_IP_ADDRESS   => $info->getIpAddress(),
            Parameter::VNPAY_LOCALE       => $info->getLocale(),
            Parameter::VNPAY_ORDER_INFO   => $info->getOrderInfo(),
            Parameter::VNPAY_ORDER_TYPE   => $info->getOrderType(),
            Parameter::VNPAY_RETURN_URL   => $info->getReturnUrl(),
            Parameter::VNPAY_TXNREF       => $info->getTxnRef(),
            Parameter::VNPAY_EXPIRE_DATE  => $info->getExpiDate(),
            Parameter::VNPAY_BANK_CODE    => $info->getBankCode(),
        ];
       
        return new WalletPay($arr);
    }
    private function setInfo($data)
    {
        $info = new InfoRequest($data);
        return $info;
    }
    private function setEnvironment()
    {
        $env = new Environment(Config::get('vnpay.vnp_Url'),
                new PartnerInfo(Config::get('vnpay.vnp_TmnCode'), Config::get('vnpay.vnp_HashSecret'),'2.1.0'),
                );
        $process = new Process($env);
        return $process;
    }
}