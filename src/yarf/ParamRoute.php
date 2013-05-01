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
            if(in_array(strtolower($req->getMethod()), $this->methods)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function call($req)
    {
        // if we get called here, we've already passed the test for urls matching, so there will be
        // a match in preg_match, assert just for safety
        preg_match($this->regex, $req->getUrl(), $arg);

        if(is_callable($this->mapping, false, $fnName)) {
            return call_user_func_array($this->mapping, array($arg[1]));
        } else {
            // check the controller exists, create it and pass the on the request param
            $map = explode('#', $this->mapping);

            if(file_exists(__DIR__ . '/../controllers/' . $map[0] . '.php')) {
                $className = $map[0];
                $controller = new $className;

                // call the function
                return call_user_func_array(array($controller, $map[1]), array($arg[1]));
            } else {
                throw new \Exception('Controller code file does not exist');
            }
        }
    }
}
