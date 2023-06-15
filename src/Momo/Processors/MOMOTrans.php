<?php

namespace Service\Payment\Momo\Processors;

use Exception;
use Service\Payment\Momo\MethodSupport\Environment;
use Service\Payment\Momo\MethodSupport\PartnerInfo;
use Illuminate\Support\Facades\Config;
use Service\Payment\Momo\MethodSupport\InfoTrans;
use Service\Payment\Momo\MethodSupport\Process;
use Service\Payment\Momo\Models\TransWalletResponse;

class MOMOTrans 
{
    public static function Process(array $data)
    {
        $trans = new MOMOTrans();
        $obj = $trans->setEnviroment();
        try {
            $response = $trans->TransStatusQuery($data, $obj);
            return $response;
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
        
    }
    private function TransStatusQuery($data, $obj): TransWalletResponse
    {
        $info = $this->setInfoTrans($data);
        $rawHash = "accessKey=".$obj->getEnvironment()->getPartnerInfo()->getAccessKey()."&orderId=".$info->getOrderId()."&partnerCode=".$obj->getEnvironment()->getPartnerInfo()->getPartnerCode()."&requestId=".$info->getRequestId();
        $signature = hash_hmac("sha256", $rawHash, $obj->getEnvironment()->getPartnerInfo()->getSecretKey());
        $data = array(
            'partnerCode' => $obj->getEnvironment()->getPartnerInfo()->getPartnerCode(),
            'requestId' => $info->getRequestId(),
            'orderId' => $info->getOrderId(),
            'requestType' => 'transactionStatus',
            'signature' => $signature,
            'lang' => 'vi'
        );
        $result =$this->execPostRequest($obj->getEnvironment()->getMomoEndpoint(), json_encode($data));
        $response = json_decode($result, true);
        $log = new Log();
        $log->processBacklog($response);
        return new TransWalletResponse($response);
    }
    private function setInfoTrans($data)
    {
        $info = new InfoTrans($data);
        return $info;
    }
    public function setEnviroment()
    {
        $env = new Environment(Config::get('momo.queryUrl'),
                new PartnerInfo(Config::get('momo.partnerCode'), Config::get('momo.accessKey'), Config::get('momo.secretKey')),
                );
        $process = new Process($env);
        return $process;
    }
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}