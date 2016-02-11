<?php

namespace RodrigoDiez\HowICodePHP\Nasa\APOD;

class APOD
{
    private $title;
    private $explanation;
    private $url;
    private $hdUrl;

    public function __construct($title, $explanation, $url, $hdUrl, $copyright, \DateTime $datetime)
    {
        $this->title = $title;
        $this->explanation = $explanation;
        $this->url = $url;
        $this->hdUrl = $hdUrl;
        $this->copyright = $copyright;
        $this->datetime = $datetime;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getExplanation()
    {
        return $this->explanation;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getHdUrl()
    {
        return $this->hdUrl;
    }

    public function getCopyright()
    {
        return $this->copyright;
    }

    public function getDateTime()
    {
        return $this->datetime;
    }
}
