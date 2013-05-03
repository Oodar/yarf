<?php

namespace spec\yarf\Database;

use PHPSpec2\ObjectBehavior;

class Collection extends ObjectBehavior
{
    function let()
    {
        $this->addModel(array(
            "id" => 1,
            "name" => "matt",
            "email" => "matt@eg.com"
        ));
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('yarf\Database\Collection');
    }

    function it_should_allow_you_to_filter_to_a_group_of_attributes()
    {
        $this->only('id')->shouldReturn(array(
            array(
                "id" => 1
            )
        ));
    }

    function it_should_throw_an_exception_if_no_attributes_match_the_only_filter()
    {
        $this->shouldThrow('Exception')->duringOnly('example');
    }

    function it_should_allow_you_to_specify_multiple_attributes_on_only_filter()
    {
        $this->only('id', 'name')->shouldReturn(array(
            array(
                "id" => 1,
                "name" => "matt"
            )
        ));
    }

    function it_should_allow_you_to_exclude_by_attributes()
    {
        $this->except('id')->shouldReturn(array(
            array(
                "name" => "matt",
                "email" => "matt@eg.com"
            )
        ));
    }

    function it_should_throw_an_exception_if_a_model_becomes_empty_on_except_filter()
    {
        $this->shouldThrow('Exception')->duringExcept('id', 'name', 'email');
    }

}
