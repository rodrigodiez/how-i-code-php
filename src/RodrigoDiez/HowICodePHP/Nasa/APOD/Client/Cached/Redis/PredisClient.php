<?php

namespace RodrigoDiez\HowICodePHP\Nasa\APOD\Client\Cached\Redis;

use RodrigoDiez\HowICodePHP\Nasa\APOD\Client\ClientInterface;
use RodrigoDiez\MockablePredis\Client as Predis;

class PredisClient implements ClientInterface
{
    private $client;
    private $predis;
    private $prefix;

    public function __construct(ClientInterface $client, Predis $predis, $prefix)
    {
        $this->client = $client;
        $this->predis = $predis;
        $this->prefix = $prefix;
    }

    public function get($time = "yesterday")
    {
        $datetime = new \DateTime($time);
        $formattedDatetime = $datetime->format('Ymd');
        $cacheKey = sprintf("%s-%s", $this->prefix, $formattedDatetime);

        if (null === $cached = $this->predis->get($cacheKey)) {

            $apod = $this->client->get($time);
            $this->predis->set(sprintf("%s-%s", $this->prefix, $formattedDatetime), serialize($apod));
        } else {
            $apod = unserialize($cached);
        }

        return $apod;
    }
}
