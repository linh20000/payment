<?php


namespace Service\Payment\Vnpay\Models;

use Service\Payment\Vnpay\Constants\RequestType;
use Service\Payment\Vnpay\Models\ApiRequest;
date_default_timezone_set('Asia/Ho_Chi_Minh');
class VRefund extends ApiRequest
{
    protected $transactionDate;
    protected $transactionType;
    protected $transactionNo;
    protected $createBy;
    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $this->setTnxRef($params['TxnRef']);
        $this->setTransactionDate($params['TransactionDate']);
        $this->setTransactionType($params['TransactionType']);
        $this->setAmount($params['amount']);
        $this->setTransactionNo($params['TransactionNo']);
        $this->setCreateBy($params['CreateBy']);
        $this->setRequestId(rand(1,10000));
        $this->setCommand('refund');
        $this->setCreateDate(date('YmdHis'));
    }
    public function setTransactionDate($transDate)
    {
        return $this->transactionDate = $transDate;
    }
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }
    public function setCreateBy($createBy)
    {
        return $this->createBy = $createBy;
    }
    public function getCreateBy()
    {
        return $this->createBy;
    }
    public function setTransactionNo($transNo)
    {
        return $this->transactionNo = $transNo;
    }
    public function getTransactionNo()
    {
        return $this->transactionNo;
    }
    public function setTransactionType($transType)
    {
        return $this->transactionType = $transType;
    }
    public function getTransactionType()
    {
        return $this->transactionType;
    }
}