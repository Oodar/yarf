<?php

namespace spec\yarf\http;

use PHPSpec2\ObjectBehavior;

class Request extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('get', '/');
    }

    function it_should_have_the_env_url()
    {
        $this->getUrl()->shouldReturn('/');
    }

    function it_should_have_the_env_method()
    {
        $this->getMethod()->shouldReturn('get');
    }
}