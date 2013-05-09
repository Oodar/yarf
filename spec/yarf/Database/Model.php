<?php

namespace spec\yarf\Database;

use PHPSpec2\ObjectBehavior;

class Model extends ObjectBehavior
{
    function let()
    {
        $this->offsetSet("id", "1");
        $this->offsetSet("name", "matt");
        $this->offsetSet("email", "matt@eg.com");
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('yarf\Database\Model');
    }

    function it_can_check_if_a_payload_contains_an_update()
    {
        $payload = array(
            "id" => "1",
            "name" => "matt",
            "email" => "matt@example.com" // this is an update to the email field
        );

        $this->hasUpdate($payload)->shouldReturn(true);
    }

    function it_should_return_false_if_no_update_in_payload()
    {
        $payload = array(
            "id" => "1",
            "name" => "matt",
            "email" => "matt@eg.com"
        );

        $this->hasUpdate($payload)->shouldReturn(false);
    }
}
