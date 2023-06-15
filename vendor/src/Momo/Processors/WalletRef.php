<?php


namespace Service\Payment\Momo\Processors;

use Exception;
use Illuminate\Support\Facades\Config;
use Service\Payment\Momo\MethodSupport\Environment;
use Service\Payment\Momo\MethodSupport\PartnerInfo;
use Service\Payment\Momo\MethodSupport\Process;
use Service\Payment\Momo\Constants\Parameter;
use Service\Payment\Momo\MethodSupport\Endcode;
use Service\Payment\Momo\MethodSupport\HttpClient;
use Service\Payment\Momo\MethodSupport\InfoRefund;
use Service\Payment\Momo\Models\WalletRefund;
use Service\Payment\Momo\Constants\RequestType;

class WalletRef
{

    public static function process(array $data)
    {
        $refundATM = new WalletRef();
        $refundRequest = $refundATM->setEnvironment();
        try {
            $ch = $refundATM->createRefundWalletRequest($data, $refundRequest);
            $refundATMResponse = $refundATM->execute($refundRequest,$ch);
            return $refundATMResponse;

        } catch (Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function createRefundWalletRequest($data, $refundRequest): WalletRefund
    {

        $info = $this->setInfo($data);
        $rawData = 
                Parameter::ACCESS_KEY . "=" . $refundRequest->getPartnerInfo()->getAccessKey() .
                "&" . Parameter::AMOUNT . "=" . $info->getAmount() .
                "&" . 'description'     . "=" . 'test' .
                "&" . Parameter::ORDER_ID . "=" . $info->getOrderId() .
            "&" . Parameter::PARTNER_CODE . "=" . $refundRequest->getPartnerInfo()->getPartnerCode() .
            "&" . Parameter::REQUEST_ID . "=" . $info->getRequestId() .
            "&" . Parameter::TRANS_ID . "=" . $info->getTransId();
        $signature = Endcode::hashSha256($rawData, $refundRequest->getPartnerInfo()->getSecretKey());
        $arr = array(
            Parameter::PARTNER_CODE => $refundRequest->getPartnerInfo()->getPartnerCode(),
            Parameter::ACCESS_KEY => $refundRequest->getPartnerInfo()->getAccessKey(),
            Parameter::REQUEST_ID => $info->getRequestId(),
            Parameter::AMOUNT => $info->getAmount(),
            Parameter::ORDER_ID => $info->getOrderId(),
            Parameter::TRANS_ID => $info->getTransId(),
            Parameter::SIGNATURE => $signature,
        );
        return new WalletRefund($arr);
    }

    public function execute($refundRequest,$refundATMRequest)
    {
        try {
            $data = [
                'partnerCode' => $refundATMRequest->getPartnerCode(),
                'orderId' => time() ."",
                'requestId' => time() ."",
                'amount' => 20000,
                'transId' => $refundATMRequest->getTransId(),
                'lang' => 'vi',
                'requestType'=> RequestType::REFUND_MOMO_WALLET,
                'signature' => $refundATMRequest->getSignature(),
            ];
            $response = HttpClient::HTTPPost($refundRequest->getEnvironment()->getMomoEndpoint(), json_encode($data));
            dd($response);
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