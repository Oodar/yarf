<?php

namespace yarf\http;

class Response
{
    protected static $responses = array(
        #1xx = information
        #2xx = success
        200 => "200 OK",
        #3xx = redirect
        #4xx = client error
        404 => "404 Not Found",
        #5xx = server error
        500 => "500 Server Error"
    );

    private $status;
    private $headers = array();
    private $body;
    private $sent;

    function __construct()
    {
        $this->sent = false;
    }


    public function setResponseCode($code)
    {
        if(array_key_exists($code, self::$responses)) {
            // a supported, valid code
            $this->status = self::$responses[$code];
        } else {
            throw new \Exception("Unsupported response code");
        }
    }

    public function getResponseCode()
    {
        return $this->status;
    }

    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    public function getHeader($header)
    {
        return $this->headers[$header];
    }

    public function sendHeaders()
    {
        // send status line
        header('HTTP/1.1 ' . $this->status);

        foreach ($this->headers as $header => $value) {
            header($header . ': ' . $value);
        }
    }

    public function isSent()
    {
        return $this->sent;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sent = true;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }
}
