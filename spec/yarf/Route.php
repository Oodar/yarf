<?php

namespace spec\yarf;

use PHPSpec2\ObjectBehavior;

class Route extends ObjectBehavior
{
    function let()
    {
       $this->beConstructedWith('/example', array("GET"));
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('yarf\Route');
    }

    function it_should_have_a_url()
    {
        $this->getUrl()->shouldReturn('/example');
    }

    function it_should_have_some_methods()
    {
        $this->getMethods()->shouldReturn(array("get"));
    }
    
    function it_should_not_allow_via_on_get_put_post_or_delete()
    {
        $this->shouldThrow('Exception')->duringVia();
    }

    /**
     * @param Yarf\Request $req
     */
    function it_should_properly_invoke_closure_functions($req)
    {

        $this->to(function() {
            return "closure";
        });

        $this->call($req)->shouldReturn("closure");
    }

    function it_should_split_class_method_hashes_properly()
    {
        // Try to map to a controller file that doesn't exist
        $this->to('Controller#index');
        $this->shouldThrow('Exception')->duringCall();
    }

    /**
     * @param Yarf\Request $req
     */
    function it_should_check_methods_when_matching($req)
    {
        $req->getUrl()->willReturn('/example');
        $req->getMethod()->willReturn("PUT");

        $this->isMatch($req)->shouldReturn(false);
    }

    /**
     * @param Yarf\Request $req
     */
    function it_should_not_care_about_case_sensitivity_on_http_methods_when_matching($req)
    {
        $req->getUrl()->willReturn('/example');
        $req->getMethod()->willReturn("get");

        $this->isMatch($req)->shouldReturn(true);
    }

}
