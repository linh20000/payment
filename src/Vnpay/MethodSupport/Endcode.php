<?php

namespace Service\Payment\Vnpay\MethodSupport;

use Illuminate\Support\Facades\Crypt;

class Endcode
{
    public static function hashSha512($hashdata, $HashSecret)
    {
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $HashSecret);
        return $vnpSecureHash;
    }
    public static function encrypt(array $rawData, $encryptionKey)
    {
        $rawJson = json_encode($rawData, JSON_UNESCAPED_UNICODE);

        $encryptedString = Crypt::encryptString($rawJson, $encryptionKey);
        $cipher = base64_encode($encryptedString);
        return $cipher;
    }

    public static function decrypt($hashData, $privateKey)
    {
        $encryptedData = base64_decode($hashData);
        $decryptedData = Crypt::decryptString($encryptedData, $privateKey);
    
        return $decryptedData;
    }
}