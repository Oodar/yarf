<?php

namespace spec\yarf;

use PHPSpec2\ObjectBehavior;

class Controller extends ObjectBehavior
{
    /**
     * @param Yarf\Environment $env
     */
    function let($env)
    {
        $_SERVER['HTTP_ACCEPT'] = "application/json";
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('yarf\Controller');
    }

    function it_should_call_a_closure_that_matches_accept_and_respond()
    {
        $this->respondTo('json', function() {
            return "json closure";
        })->shouldReturn("json closure");
    }

    function it_should_return_false_if_respond_doesnt_match_accept()
    {
        $this->respondTo('xml', function() {
            return "xml closure";
        })->shouldReturn(false);
    }
}
