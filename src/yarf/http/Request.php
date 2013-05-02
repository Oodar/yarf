<?php

namespace yarf\http;

class Request
{
    private $url;
    private $method;

    function __construct($method, $url)
    {
        $this->url = $url;
        $this->method = $method;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getMethod()
    {
        return $this->method;
    }
}
