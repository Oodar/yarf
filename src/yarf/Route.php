<?php

namespace yarf;

class Route
{
    protected $url;
    protected $mapping;
    protected $methods = array();
    protected $enforced;

    function __construct($url, array $methods = array())
    {
        $this->url = $url;
        if(empty($methods)) {
            $this->enforced = false;
        } else {
            $this->enforced = true;
        }
        
        $this->methods = array_map('strtolower', $methods);
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function via()
    {
        $args = func_get_args();
        if($this->enforced) {
            // can't set a method using via, this is a get/put/post/delete route
            throw new \Exception("Can't do this on enforced routes");
        } else {
            // can set the methods
            foreach ($args as $method) {
                array_push($this->methods, strtolower($method));
            }
        }
    }

    public function isMatch($req)
    {
        if($req->getUrl() == $this->url) {
            if(in_array(strtolower($req->getMethod()), $this->methods)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function to($mapping)
    {
        $this->mapping = $mapping;
    }

    public function call($req)
    {
        if(is_callable($this->mapping, false, $fnName)) {
            // call it
            return call_user_func($this->mapping);
        } else {
            // not a callable
            $map = explode('#', $this->mapping);

            // check if it exists
            if(file_exists(__DIR__ . "/../controllers/" . $map[0] . ".php")) {
                // create the controller
                $className = $map[0];
                $controller = new $className;

                // call the function
                return call_user_func_array(array($controller, $map[1]), array());
            } else {
                throw new \Exception('Controller code file does not exist');
            }
        }
    }
}
