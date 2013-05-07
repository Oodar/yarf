<?php

namespace spec\yarf\http;

use PHPSpec2\ObjectBehavior;

class Response extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('yarf\http\Response');
    }

    function it_can_map_response_codes_to_human_readable()
    {
        $this->setResponseCode(200);
        $this->getResponseCode()->shouldReturn("200 OK");
    }

    function it_can_add_new_headers_to_be_returned_to_client()
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->getHeader('Content-Type')->shouldReturn('application/json');
    }

    function it_is_sent_after_sending()
    {
        $this->send();
        $this->isSent()->shouldReturn(true);
    }

}
