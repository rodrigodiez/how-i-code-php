<?php

namespace spec\RodrigoDiez\HowICodePHP\Nasa\APOD\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ClientSpec extends ObjectBehavior
{
    private $defaultEndpoint = 'https://api.nasa.gov/planetary/apod/default';
    private $defaultApiKey = 'nasa_api_key_default';
    private $defaultResponseBody = [
        'title' => 'Sample title default',
        'explanation' => 'Sample explanation default',
        'url' => 'http://apod.nasa.gov/apod/image/1602/N1532_LRGB_50_finishCedic_default.jpg',
        'hdurl' => 'http://apod.nasa.gov/apod/image/1602/N1532_LRGB_50_finishCedic_hd_default.jpg',
        'copyright' => 'Sample copyright default',
        'date' => '1982-10-21'
    ];

    function let(Client $httpClient, ResponseInterface $response, StreamInterface $responseBodyStream)
    {
        $responseBodyStream->__toString()->willReturn(json_encode($this->defaultResponseBody));
        $response->getBody()->willReturn($responseBodyStream);

        $this->beConstructedWith($httpClient, $this->defaultEndpoint, $this->defaultApiKey);
        $httpClient->request(Argument::any(), Argument::any(), Argument::any())->willReturn($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('RodrigoDiez\HowICodePHP\Nasa\APOD\Client\Client');
    }

    function it_makes_a_get_request_to_provided_endpoint(Client $httpClient, ResponseInterface $response)
    {
        $endpoint = 'https://api.nasa.gov/planetary/apod';
        $this->beConstructedWith($httpClient, $endpoint, $this->defaultApiKey);

        $httpClient->request('GET', $endpoint, Argument::any())->shouldBeCalled()->willReturn($response);

        $this->get();
    }

    function it_uses_provided_api_key(Client $httpClient, ResponseInterface $response)
    {
        $apiKey = 'nasa_api_key';
        $this->beConstructedWith($httpClient, $this->defaultEndpoint, $apiKey);

        $httpClient->request('GET', Argument::any(), Argument::that(function($argument) use ($apiKey){
            return $argument['query']['api_key'] === $apiKey;
        }))->shouldBeCalled()->willReturn($response);

        $this->get();
    }

    function it_request_yesterdays_apod_by_default(Client $httpClient, ResponseInterface $response)
    {
        $yesterday = new \DateTime('yesterday');

        $httpClient->request('GET', Argument::any(), Argument::that(function($argument) use ($yesterday){
            return $argument['query']['date'] === $yesterday->format('Y-m-d');
        }))->shouldBeCalled()->willReturn($response);

        $this->get();
    }

    function it_request_provided_time_apod(Client $httpClient, ResponseInterface $response)
    {
        $today = new \DateTime('today');

        $httpClient->request('GET', Argument::any(), Argument::that(function($argument) use ($today){
            return $argument['query']['date'] === $today->format('Y-m-d');
        }))->shouldBeCalled()->willReturn($response);

        $this->get('today');
    }

    function it_returns_an_APOD_object(Client $httpClient)
    {
        $this->get()->shouldHaveType('RodrigoDiez\HowICodePHP\Nasa\APOD\APOD');
    }

    function it_returns_an_APOD_object_with_the_same_title_the_response_has(Client $httpClient, ResponseInterface $response, StreamInterface $responseBodyStream)
    {
        $title = 'Sample title';
        $responseBody = $this->defaultResponseBody;
        $responseBody['title'] = $title;

        $responseBodyStream->__toString()->willReturn(json_encode($responseBody));
        $response->getBody()->willReturn($responseBodyStream);

        $apod = $this->get();

        $apod->getTitle()->shouldReturn($title);
    }

    function it_returns_an_APOD_object_with_the_same_explanation_the_response_has(Client $httpClient, ResponseInterface $response, StreamInterface $responseBodyStream)
    {
        $explanation = 'Sample explanation';
        $responseBody = $this->defaultResponseBody;
        $responseBody['explanation'] = $explanation;

        $responseBodyStream->__toString()->willReturn(json_encode($responseBody));
        $response->getBody()->willReturn($responseBodyStream);

        $apod = $this->get();

        $apod->getExplanation()->shouldReturn($explanation);
    }

    function it_returns_an_APOD_object_with_the_same_url_the_response_has(Client $httpClient, ResponseInterface $response, StreamInterface $responseBodyStream)
    {
        $url = 'http://apod.nasa.gov/apod/image/1602/N1532_LRGB_50_finishCedic.jpg';
        $responseBody = $this->defaultResponseBody;
        $responseBody['url'] = $url;

        $responseBodyStream->__toString()->willReturn(json_encode($responseBody));
        $response->getBody()->willReturn($responseBodyStream);

        $apod = $this->get();

        $apod->getUrl()->shouldReturn($url);
    }

    function it_returns_an_APOD_object_with_the_same_hdUrl_the_response_has(Client $httpClient, ResponseInterface $response, StreamInterface $responseBodyStream)
    {
        $hdUrl = 'http://apod.nasa.gov/apod/image/1602/N1532_LRGB_50_finishCedic_hd.jpg';
        $responseBody = $this->defaultResponseBody;
        $responseBody['hdurl'] = $hdUrl;

        $responseBodyStream->__toString()->willReturn(json_encode($responseBody));
        $response->getBody()->willReturn($responseBodyStream);

        $apod = $this->get();

        $apod->getHdUrl()->shouldReturn($hdUrl);
    }

    function it_returns_an_APOD_object_with_the_same_copyright_the_response_has(Client $httpClient, ResponseInterface $response, StreamInterface $responseBodyStream)
    {
        $copyright = 'Sample copyright';
        $responseBody = $this->defaultResponseBody;
        $responseBody['copyright'] = $copyright;

        $responseBodyStream->__toString()->willReturn(json_encode($responseBody));
        $response->getBody()->willReturn($responseBodyStream);

        $apod = $this->get();

        $apod->getCopyright()->shouldReturn($copyright);
    }

    function it_returns_an_APOD_object_with_the_same_date_the_response_has(Client $httpClient, ResponseInterface $response, StreamInterface $responseBodyStream)
    {
        $date = '2016-01-01';
        $responseBody = $this->defaultResponseBody;
        $responseBody['date'] = $date;

        $responseBodyStream->__toString()->willReturn(json_encode($responseBody));
        $response->getBody()->willReturn($responseBodyStream);

        $apod = $this->get();

        $datetime = $apod->getDateTime();
        $datetime->format('Y-m-d')->shouldBe($date);
    }
}
