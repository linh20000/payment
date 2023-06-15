<?php

namespace Service\Payment\Vnpay\Processors;

use Exception;
use Illuminate\Support\Facades\Config;
use Service\Payment\Vnpay\MethodSupport\Endcode;
use Service\Payment\Vnpay\MethodSupport\Environment;
use Service\Payment\Vnpay\MethodSupport\HttpClient;
use Service\Payment\Vnpay\MethodSupport\Process;
use Service\Payment\Vnpay\MethodSupport\PartnerInfo;
use Service\Payment\Vnpay\Models\VRefund;

date_default_timezone_set('Asia/Ho_Chi_Minh');
error_reporting(E_ALL & E_NOTICE & E_DEPRECATED);

class VNPAYRefund
{

    

      public static function Process($data)
      {
        $object = new VNPAYRefund();
        $refund = $object->setEnvironment();
        try {
            $response = $object->CreateRequestRefund($refund, $data);
            return $response;
        } catch(Exception $e) {
            var_dump($e->getMessage());
        }
      }
      private function CreateRequestRefund($refund , $data)
      {
        $info = $this->setInfoRequest($data);
            $vnp_RequestId = $info->getRequestId(); 
            $vnp_Command = $info->getCommand(); 
            $vnp_TransactionType = $info->getTransactionType(); 
            $vnp_TxnRef = $info->getTxnRef(); 
            $vnp_Amount = $info->getAmount() * 100; 
            $vnp_OrderInfo = "Hoan Tien Giao Dich"; 
            $vnp_TransactionNo = $info->getTransactionNo();
            $vnp_TransactionDate = $info->getTransactionDate(); 
            $vnp_CreateDate = $info->getCreateDate(); 
            $vnp_CreateBy = $data["CreateBy"];
            $vnp_IpAddr = request()->ip(); 
            $ispTxnRequest = array(
                "vnp_RequestId" => $vnp_RequestId,
                "vnp_Version" => $refund->getPartnerInfo()->getVersion(),
                "vnp_Command" => $vnp_Command,
                "vnp_TmnCode" => $refund->getPartnerInfo()->getTmnCode(),
                "vnp_TransactionType" => $vnp_TransactionType,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_Amount" => $vnp_Amount,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_TransactionNo" => $vnp_TransactionNo,
                "vnp_TransactionDate" => $vnp_TransactionDate,
                "vnp_CreateDate" => $vnp_CreateDate,
                "vnp_CreateBy" => $vnp_CreateBy,
                "vnp_IpAddr" => $vnp_IpAddr
            );
            $format = '%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s';
  
            $dataHash = sprintf(
                $format,
                $ispTxnRequest['vnp_RequestId'], //1
                $ispTxnRequest['vnp_Version'], //2
                $ispTxnRequest['vnp_Command'], //3
                $ispTxnRequest['vnp_TmnCode'], //4
                $ispTxnRequest['vnp_TransactionType'], //5
                $ispTxnRequest['vnp_TxnRef'], //6
                $ispTxnRequest['vnp_Amount'], //7
                $ispTxnRequest['vnp_TransactionNo'],  //8
                $ispTxnRequest['vnp_TransactionDate'], //9
                $ispTxnRequest['vnp_CreateBy'], //10
                $ispTxnRequest['vnp_CreateDate'], //11
                $ispTxnRequest['vnp_IpAddr'], //12
                $ispTxnRequest['vnp_OrderInfo'] //13
            ); 
            $checksum = Endcode::hashSha512($dataHash,$refund->getPartnerInfo()->getHashSecret());
            $ispTxnRequest["vnp_SecureHash"] = $checksum;
            $txnData = HttpClient::HttpRefundClient("POST", Config::get('vnpay.apiUrl'), json_encode($ispTxnRequest));
            $ispTxn = json_decode($txnData, true);
            return response()->json($ispTxn);
      }
      private function setInfoRequest($data)
      {
        $setInfo = new VRefund($data);
        return $setInfo;
      }
      private function setEnvironment()
      {
          $env = new Environment(Config::get('vnpay.apiUrl'),
                  new PartnerInfo(Config::get('vnpay.vnp_TmnCode'), Config::get('vnpay.vnp_HashSecret'),'2.1.0'),
                  );
          return $env;
      }
      
}
