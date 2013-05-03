<?php

namespace spec\yarf;

use PHPSpec2\ObjectBehavior;

class ParamRoute extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('/users/:id', array("GET"));
    }

    /**
     * @param Yarf\Request $req
     */
    function it_matches_parametered_requests($req)
    {
        $req->getUrl()->willReturn('/users/1');
        $req->getMethod()->willReturn("GET");
        $this->isMatch($req)->shouldReturn(true);
    }

    /**
     * @param Yarf\Request $req
     */
    function it_should_check_methods_when_matching($req)
    {
        $req->getUrl()->willReturn('/users/1');
        $req->getMethod()->willReturn("PUT");

        $this->isMatch($req)->shouldReturn(false);
    }
}
