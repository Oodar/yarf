<?php

namespace yarf;

class Environment
{
    /**
     * Returns an array of accepted encoding types from the HTTP request
     */
    static public function getAcceptedTypes()
    {
        if(isset($_SERVER['HTTP_ACCEPT'])) {
            return explode(',',$_SERVER['HTTP_ACCEPT']);
        } else {
            return array();
        }
    }
}
