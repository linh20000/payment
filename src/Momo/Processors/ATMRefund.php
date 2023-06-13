<?php


namespace Service\Payment\Momo\Processors;

use Exception;
use Illuminate\Support\Facades\Config;
use Service\Payment\Momo\MethodSupport\Environment;
use Service\Payment\Momo\MethodSupport\PartnerInfo;
use Service\Payment\Momo\MethodSupport\Process;
use Service\Payment\Momo\Constants\Parameter;
use Service\Payment\Momo\MethodSupport\Endcode;
use GuzzleHttp\Client;
use Service\Payment\Momo\MethodSupport\HttpClient;
use Service\Payment\Momo\MethodSupport\InfoRefund;
use Service\Payment\Momo\Models\ATMRefundRequest;
use Service\Payment\Momo\Constants\RequestType;

class ATMRefund 
{

    public static function process(array $data)
    {
        $refundATM = new ATMRefund();
        $refundRequest = $refundATM->setEnvironment();
        try {
            $ch = $refundATM->createRefundATMRequest($data, $refundRequest);
            $refundATMResponse = $refundATM->execute($refundRequest,$ch);
            return $refundATMResponse;

        } catch (Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function createRefundATMRequest($data, $refundRequest): ATMRefundRequest
    {

        $info = $this->setInfo($data);
        $rawData = Parameter::PARTNER_CODE . "=" . $refundRequest->getPartnerInfo()->getPartnerCode() .
            "&" . Parameter::ACCESS_KEY . "=" . $refundRequest->getPartnerInfo()->getAccessKey() .
            "&" . Parameter::REQUEST_ID . "=" . $info->getRequestId() .
            "&" . Parameter::BANK_CODE . "=" . 'SML' .
            "&" . Parameter::AMOUNT . "=" . $info->getAmount() .
            "&" . Parameter::ORDER_ID . "=" . $info->getOrderId() .
            "&" . Parameter::TRANS_ID . "=" . $info->getTransId();
            "&" . Parameter::REQUEST_TYPE . "=" . RequestType::REFUND_ATM;
        $signature = Endcode::hashSha256($rawData, $refundRequest->getPartnerInfo()->getSecretKey());
        $arr = array(
            Parameter::PARTNER_CODE => $refundRequest->getPartnerInfo()->getPartnerCode(),
            Parameter::ACCESS_KEY => $refundRequest->getPartnerInfo()->getAccessKey(),
            Parameter::REQUEST_ID => $info->getRequestId(),
            Parameter::AMOUNT => $info->getAmount(),
            Parameter::BANK_CODE => 'SML',
            Parameter::ORDER_ID => $info->getOrderId(),
            Parameter::TRANS_ID => $info->getTransId(),
            Parameter::REQUEST_TYPE => RequestType::REFUND_ATM,
            Parameter::SIGNATURE => $signature,
        );
        return new ATMRefundRequest($arr);
    }

    public function execute($refundRequest,$refundATMRequest)
    {
        try {
            $data = [
                'partnerCode' => $refundATMRequest->getPartnerCode(),
                'orderId' => $refundATMRequest->getOrderId(),
                'requestId' => $refundATMRequest->getRequestId(),
                'amount' => $refundATMRequest->getAmount(),
                'bankCode' =>'SML',
                'orderInfo' => $refundATMRequest->getTransId(),
                'lang' => 'vi',
                'requestType'=> RequestType::REFUND_ATM,
                'signature' => $refundATMRequest->getSignature(),
            ];
            $response = HttpClient::HTTPPost($refundRequest->getEnvironment()->getMomoEndpoint(), json_encode($data));
            return $response;
        } catch (Exception $exception) {
           
        }
    }
    
    private function setInfo($data)
    {
        $info = new InfoRefund($data);
        return $info;
    }
    private function setEnvironment()
    {
        $env = new Environment('https://test-payment.momo.vn/gw_payment/transactionProcessor',
                new PartnerInfo(Config::get('momo.partnerCode'), Config::get('momo.accessKey'), Config::get('momo.secretKey')),
                );
        $process = new Process($env);
        return $process;
    }
}