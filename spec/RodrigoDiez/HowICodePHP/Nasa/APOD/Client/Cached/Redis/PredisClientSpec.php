<?php

namespace spec\RodrigoDiez\HowICodePHP\Nasa\APOD\Client\Cached\Redis;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RodrigoDiez\HowICodePHP\Nasa\APOD\Client\Client;
use RodrigoDiez\HowICodePHP\Nasa\APOD\APOD;
use RodrigoDiez\MockablePredis\Client as Predis;

class PredisClientSpec extends ObjectBehavior
{
    private $defaultPrefix = 'prefix_default';

    function let(Client $client, Predis $predis, APOD $apod)
    {
        $predis->get(Argument::any())->willReturn(null);
        $predis->set(Argument::cetera())->willReturn(null);

        $this->beConstructedWith($client, $predis, $this->defaultPrefix);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('RodrigoDiez\HowICodePHP\Nasa\APOD\Client\Cached\Redis\PredisClient');
    }

    function it_implements_ClientInterface()
    {
        $this->shouldImplement('RodrigoDiez\HowICodePHP\Nasa\APOD\Client\ClientInterface');
    }

    function it_serializes_and_store_in_cache_the_object_returned_by_Client(Client $client, Predis $predis)
    {
        $apod = new APOD("Sample title", "Sample explanation", "http://sample.url", "http://sample.hd.url", "Sample copyright", new \DateTime("yesterday"));

        $client->get(Argument::any())->shouldBeCalled()->willReturn($apod);
        $predis->set(Argument::any(), serialize($apod))->shouldBeCalled();

        $this->get();
    }

    function it_uses_provided_prefix_and_requested_Ymd_as_key_to_store_it_in_cache(Client $client, APOD $apod, Predis $predis)
    {
        $timestring = "yesterday";
        $prefix = 'sample-prefix';
        $datetime = new \DateTime($timestring);
        $expectedKey = sprintf("%s-%s", $prefix, $datetime->format('Ymd'));

        $this->beConstructedWith($client, $predis, $prefix);

        $client->get(Argument::any())->shouldBeCalled()->willReturn($apod);
        $predis->set($expectedKey, Argument::any())->shouldBeCalled();

        $this->get($timestring);
    }

    function it_returns_the_object_returned_by_Client(Client $client, APOD $apod, Predis $predis)
    {
        $client->get(Argument::any())->shouldBeCalled()->willReturn($apod);

        $returnedApod = $this->get();

        $returnedApod->shouldBe($apod);
    }

    function it_uses_provided_prefix_and_requested_Ymd_as_key_to_find_in_cache(Client $client, APOD $apod, Predis $predis)
    {
        $timestring = "yesterday";
        $prefix = 'sample-prefix';
        $datetime = new \DateTime($timestring);
        $expectedKey = sprintf("%s-%s", $prefix, $datetime->format('Ymd'));

        $this->beConstructedWith($client, $predis, $prefix);

        $predis->get($expectedKey)->shouldBeCalled();

        $this->get($timestring);
    }

    function it_returns_the_unserialized_object_returned_by_cache(Client $client, Predis $predis)
    {
        $apod = new APOD("Sample title", "Sample explanation", "http://sample.url", "http://sample.hd.url", "Sample copyright", new \DateTime("yesterday"));
        $predis->get(Argument::any())->willReturn(serialize($apod));

        $returnedApod = $this->get();

        $returnedApod->shouldBeLike($apod);
    }

    function it_does_not_use_Client_if_cache_hit(Client $client, APOD $apod, Predis $predis)
    {
        $predis->get(Argument::any())->willReturn(serialize($apod->getWrappedObject()));
        $client->get()->shouldNotBeCalled();

        $this->get();
    }

    function it_does_not_stores_object_in_cache_if_cache_hit(Client $client, APOD $apod, Predis $predis)
    {
        $predis->get(Argument::any())->willReturn(serialize($apod->getWrappedObject()));
        $predis->set()->shouldNotBeCalled();

        $this->get();
    }
}
