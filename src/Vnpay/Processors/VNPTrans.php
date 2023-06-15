<?php


namespace Service\Payment\Vnpay\Processors;
use Service\Payment\Vnpay\MethodSupport\Environment;
use Service\Payment\Vnpay\MethodSupport\PartnerInfo;
use Illuminate\Support\Facades\Config;
use Service\Payment\Vnpay\MethodSupport\Process;
use Exception;
use Service\Payment\Vnpay\Processors\Log;

class VNPTrans
{
    public static function Process(array $data)
    {
        $object = new VNPTrans();
        $atm = $object->setEnvironment();
        // dd($atm->getEnvironment()->getPartnerInfo()->getHashSecret());
        $inputData = array();
        $returnData = array();
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);  
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $atm->getEnvironment()->getPartnerInfo()->getHashSecret());
        $vnpTranId = $inputData['vnp_TransactionNo']; 
        $vnp_BankCode = $inputData['vnp_BankCode']; 
        $vnp_Amount = $inputData['vnp_Amount']; 

        $Status = 0; 
        $orderId = $inputData['vnp_TxnRef'];

        try {
            if ($secureHash == $vnp_SecureHash) {
                if ($data != NULL) {
                    if($data["vnp_Amount"] == $vnp_Amount) 
                    {
                        $inputData['vnp_Amount'] = $data['vnp_Amount'];
                        if ($inputData['vnp_ResponseCode'] == '00' && $inputData['vnp_TransactionStatus'] == '00') {
                            $Status = 1;
                        } else {
                            $Status = 2; 
                        }
                        if ($Status == 1) {
                            Log::processBacklog($inputData);
                        }
                        $returnData['RspCode'] = '00';
                        $returnData['response'] = json_encode($inputData);
                        $returnData['Message'] = 'Confirm Success';
                    
                    }
                    else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
            return $returnData;
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
    }
    private function setEnvironment()
    {
        $env = new Environment(Config::get('vnpay.apiUrl'),
        new PartnerInfo(Config::get('vnpay.vnp_TmnCode'), Config::get('vnpay.vnp_HashSecret'),'2.1.0'),
                );
        $process = new Process($env);
        return $process;
            }
}