<?php

namespace yarf;

class Controller
{
    protected $respondTypes = array();

    function __construct()
    {
    }

    public function respondTo($type, $function)
    {
        // you'd still have to actually get the collection passed into the closure somehow
        // this has to happen here, magically
        assert('is_callable($function)');
        if($this->matchesAcceptType($type)) {
            // call function
            return call_user_func($function);
        } else {
            // don't call function
            return false;
        }
    }

    private function matchesAcceptType($type)
    {
        $accept = Environment::getAcceptedTypes();

        foreach ($accept as $acceptType) {

            if(strstr($acceptType, $type)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
