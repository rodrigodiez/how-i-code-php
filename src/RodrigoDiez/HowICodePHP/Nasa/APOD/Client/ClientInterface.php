<?php

namespace RodrigoDiez\HowICodePHP\Nasa\APOD\Client;

interface ClientInterface
{
    public function get($time = "yesterday");
}
