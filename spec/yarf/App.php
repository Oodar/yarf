<?php

namespace spec\yarf;

use PHPSpec2\ObjectBehavior;

class App extends ObjectBehavior
{

    function let()
    {
        $this->get('/closure')->to(function() {
            return "closure";
        });

        $this->get('/closure/:id')->to(function($id) {
            return "closure id: " . $id;
        });

        $this->get('/example')->to('Example#index');
        $this->get('/example/:id')->to('Example#paramWithId');

        $this->get('/collectionTest')->to('Example#collection');
    }

    function it_can_return_all_its_routes()
    {
        $this->getRoutes()->shouldBeArray();
    }

    function it_should_be_able_to_add_routes()
    {
        $currCount = count($this->getRoutes());
        $this->get('/example');

        $this->getRoutes()->shouldNotHaveCount($currCount);
    }

    function its_routing_functions_return_a_route_object()
    {
        $this->get('/eg')->shouldHaveType('Yarf\Route');
    }

    function it_has_routing_functions_that_correspond_to_http_methods()
    {
        $this->shouldNotThrow('Exception')->duringGet('/eg');
        $this->shouldNotThrow('Exception')->duringPut('/eg');
        $this->shouldNotThrow('Exception')->duringPost('/eg');
        $this->shouldNotThrow('Exception')->duringDelete('/eg');
    }

    function it_has_a_match_function_for_wildcard_http_methods()
    {
        $this->shouldNotThrow('Exception')->duringMatch('/eg');
    }

    function it_passes_run_params_to_closure()
    {
        $_SERVER['REQUEST_METHOD'] = 'get';
        $_SERVER['REQUEST_URI'] = '/closure/1';

        $this->run()->shouldReturn("closure id: 1");
    }


    /**
     * @param Yarf\Request $req
     */
    /*
    function it_passes_run_params_to_controller($req)
    {
        $_SERVER['REQUEST_METHOD'] = 'get';
        $_SERVER['REQUEST_URI'] = '/example/1';

        $this->run($req)->shouldReturn('Example#paramWithId: 1');
    }
    */

    /**
     * @param Yarf\Request $req
     */
    function it_can_map_runs_to_the_routes_controller_mapping($req)
    {
        $_SERVER['REQUEST_METHOD'] = 'get';
        $_SERVER['REQUEST_URI'] = '/closure';

        $this->run($req)->shouldReturn("closure");
    }

    /**
     * @param Yarf\Request $req
     */
    /*
    function it_can_forward_runs_to_a_controller_object($req)
    {
        $_SERVER['REQUEST_METHOD'] = 'get';
        $_SERVER['REQUEST_URI'] = '/example';

        $this->run($req)->shouldReturn("Example#index");
    }
    */

    /**
     * @param Yarf\Request $req
     */
    /*
    function it_passes_the_collection_to_the_respond_to_closure_if_accept_header_matches($req)
    {
        $_SERVER['REQUEST_METHOD'] = 'get';
        $_SERVER['REQUEST_URI'] = '/collectionTest';

        $_SERVER['HTTP_ACCEPT'] = "application/json";

        $this->run($req)->shouldReturn(array(
            array(
                "id" => "1",
                "name" => "matt",
                "email" => "matt@eg.com"
            ),
            array(
                "id" => "2",
                "name" => "andy",
                "email" => "andy@eg.com"
            )
        ));
    }
    */
}