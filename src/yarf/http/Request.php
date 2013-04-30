<?php

namespace yarf\http;

class Request
{
    private $url;
    private $method;

    function __construct($env)
    {
        $this->url = $env->getRequestUrl();
        $this->method = $env->getRequestMethod();
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
