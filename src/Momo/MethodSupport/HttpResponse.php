<?php


namespace Service\Payment\Momo\MethodSupport;

class HttpResponse
{
    protected $statusCode;
    protected $body;

    public function __construct($statusCode, $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

 
    public function setStatusCode($statusCode): void
    {
        $this->statusCode = $statusCode;
    }

 
    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body): void
    {
        $this->body = $body;
    }
}