<?php

namespace spec\RodrigoDiez\HowICodePHP\Nasa\APOD;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class APODSpec extends ObjectBehavior
{
    private $defaultTitle = 'A sample default title';
    private $defaultExplanation = 'A sample default explanation';
    private $defaultUrl = "http://apod.nasa.gov/apod/image/1602/N1532_LRGB_50_finishCedic_default.jpg";
    private $defaultHdUrl = "http://apod.nasa.gov/apod/image/1602/N1532_LRGB_50_finishCedic_hd_default.jpg";
    private $defaultCopyright = "CEDIC Team default";
    private $defaultDatetime = null;

    function let()
    {
        $this->defaultDatetime = new \DateTime();

        $this->beConstructedWith($this->defaultTitle, $this->defaultExplanation, $this->defaultUrl, $this->defaultHdUrl, $this->defaultCopyright, $this->defaultDatetime);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('RodrigoDiez\HowICodePHP\Nasa\APOD\APOD');
    }

    function it_returns_provided_title()
    {
        $title = "A sample title";
        $this->beConstructedWith($title, $this->defaultExplanation, $this->defaultUrl, $this->defaultHdUrl, $this->defaultCopyright, $this->defaultDatetime);

        $this->getTitle()->shouldReturn($title);
    }

    function it_returns_provided_explanation()
    {
        $explanation = "A sample explanation";
        $this->beConstructedWith($this->defaultTitle, $explanation, $this->defaultUrl, $this->defaultHdUrl, $this->defaultCopyright, $this->defaultDatetime);

        $this->getExplanation()->shouldReturn($explanation);
    }

    function it_returns_provided_url()
    {
        $url = "http://apod.nasa.gov/apod/image/1602/N1532_LRGB_50_finishCedic.jpg";
        $this->beConstructedWith($this->defaultTitle, $this->defaultExplanation, $url, $this->defaultHdUrl, $this->defaultCopyright, $this->defaultDatetime);

        $this->getUrl()->shouldReturn($url);
    }

    function it_returns_provided_hdurl()
    {
        $hdUrl = "http://apod.nasa.gov/apod/image/1602/N1532_LRGB_50_finishCedic_hd.jpg";
        $this->beConstructedWith($this->defaultTitle, $this->defaultExplanation, $this->defaultUrl, $hdUrl, $this->defaultCopyright, $this->defaultDatetime);

        $this->getHdUrl()->shouldReturn($hdUrl);
    }

    function it_returns_provided_copyright()
    {
        $copyright = "CEDIC Team";
        $this->beConstructedWith($this->defaultTitle, $this->defaultExplanation, $this->defaultUrl, $this->defaultHdUrl, $copyright, $this->defaultDatetime);

        $this->getCopyright()->shouldReturn($copyright);
    }

    function it_returns_provided_datetime()
    {
        $datetime = new \DateTime("yesterday");
        $this->beConstructedWith($this->defaultTitle, $this->defaultExplanation, $this->defaultUrl, $this->defaultHdUrl, $this->defaultCopyright, $datetime);

        $this->getDateTime()->shouldReturn($datetime);
    }
}
