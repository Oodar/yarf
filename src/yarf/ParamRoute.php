<?php

namespace yarf;

class ParamRoute extends Route
{
    private $regex;

    function __construct($url, array $methods = array())
    {
        // incoming url has variable
        $regex = preg_replace("#(:[a-z]+)$#", "([a-z0-9]+)", $url);
        $regex = trim($regex, "\n");
        $regex = "#^" . $regex . "$#";

        $this->regex = $regex;

        parent::__construct($url, $methods);
    }

    public function isMatch($req)
    {
        //echo "Preg Match output: " . preg_match($this->regex, $req->getUrl());
        if(preg_match($this->regex, $req->getUrl()) > 0) {
            if(in_array($req->getMethod(), $this->methods)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
