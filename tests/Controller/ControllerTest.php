<?php

namespace App\Controller;

// use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class Controller.
 */
class ControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Try accessing route 'home' with a GET request and ensure it returns status 200.
     */
    public function testHomeRoute()
    {
        $route = '/';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Try accessing route 'about' with a GET request and ensure it returns status 200.
     */
    public function testAboutRoute()
    {
        $route = '/about';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Try accessing route 'report' with a GET request and ensure it returns status 200.
     */
    public function testReportRoute()
    {
        $route = '/report';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Try accessing route 'lucky' with a GET request and ensure it returns status 200.
     */
    public function testLuckyRoute()
    {
        $route = '/lucky';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Try accessing route 'api/quote' with a GET request and ensure it returns status 200.
     */
    public function testQuoteRoute()
    {
        $route = '/api/quote';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('quote', $data);
        $this->assertArrayHasKey('date', $data);
        $this->assertArrayHasKey('time', $data);
    }

    /**
     * Try accessing route 'metrics' with a GET request and ensure it returns status 200.
     */
    public function testMetricsRoute()
    {
        $route = '/metrics';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }
}
