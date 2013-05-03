<?php

namespace spec\yarf\Util;

use PHPSpec2\ObjectBehavior;

class Inflection extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('yarf\Util\Inflection');
    }

    function it_can_pluralize_regular_words()
    {
        $this::pluralize("bee")->shouldReturn("bees");
    }

    function it_can_pluralize_irregular_words()
    {
        $this::pluralize("child")->shouldReturn("children");
    }

    function it_can_pluralize_uncountables()
    {
        $this::pluralize("rice")->shouldReturn("rice");
    }
}
