<?php

namespace spec\RodrigoDiez\HowICodePHP\Nasa\APOD\Client\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('RodrigoDiez\HowICodePHP\Nasa\APOD\Client\Exception\ClientException');
    }

    function it_is_an_exception()
    {
        $this->shouldHaveType('\Exception');
    }
}
