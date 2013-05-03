<?php

namespace spec\yarf;

use PHPSpec2\ObjectBehavior;

class Router extends ObjectBehavior
{
    function let()
    {
        $this->addRoute('/eg', array("GET"));
        $this->addRoute('/eg/:id', array("GET"));
    }

    function it_should_have_an_array_of_routes()
    {
        $this->getRoutes()->shouldBeArray();
    }

    function it_adds_new_routes()
    {
        $this->getRoutes()->shouldHaveCount(2);
    }

    function it_returns_a_route_object_when_adding_routes()
    {
        $this->addRoute('/eg2', array("GET"))->shouldHaveType('Yarf\Route');
    }

    /**
     * @param Yarf\Request $req
     */
    function it_allows_you_to_specify_http_methods_by_chaining($req)
    {
        $req->getUrl()->willReturn("/eg3");
        $req->getMethod()->willReturn("GET");
        
        $this->addRoute('/eg3')->via("GET");
        $this->map($req)->getUrl()->shouldReturn('/eg3');
    }

    function it_creates_the_right_route_type_for_url()
    {
        $this->addRoute('/nonparam')->shouldHaveType('Yarf\Route');
        $this->addRoute('/param/:id')->shouldHaveType('Yarf\ParamRoute');
    }

    /**
     * @param Yarf\Request $req
     */
    function it_can_map_request_urls_to_a_route($req)
    {
        $req->getUrl()->willReturn('/eg');
        $req->getMethod()->willReturn("GET");
        $this->map($req)->getUrl()->shouldReturn('/eg');
    }

    /**
     * @param Yarf\Request $req
     */
    function it_can_map_parametered_request_urls_to_a_route($req)
    {
        $req->getUrl()->willReturn('/eg/1');
        $req->getMethod()->willReturn("GET");
        $this->map($req)->getUrl()->shouldReturn('/eg/:id');
    }

    /**
     * @param Yarf\Request $req
     */
    function it_returns_false_if_it_cant_find_a_route($req)
    {
        $req->getUrl()->willReturn('/asdasd');
        $this->map($req)->shouldReturn(false);
    }
}
