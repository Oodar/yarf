<?php

namespace yarf\Database;

class Model implements \ArrayAccess
{
    private $props = array();

    function __construct()
    {
    }
    
    // which of these will work?
    public function __set($offset, $value)
    {
        $this->props[$offset] = $value;
    }

    public function offsetSet($offset, $value)
    {
        $this->props[$offset] = $value;
    }

    public function offsetGet($offset)
    {
        return $this->props[$offset];
    }

    public function offsetUnset($offset)
    {
        unset($this->props[$offset]);
    }

    public function offsetExists($offset)
    {
        return isset($this->props[$offset]);
    }

}
