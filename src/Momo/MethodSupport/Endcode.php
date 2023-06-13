<?php

namespace Service\Payment\Momo\MethodSupport;

use Illuminate\Support\Facades\Crypt;

class Endcode
{
    public static function hashSha256($rawData, $secretKey)
    {
        $signature = hash_hmac("sha256", $rawData, $secretKey);
        return $signature;
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