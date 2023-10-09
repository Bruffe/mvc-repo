<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class ProjectControllerJSON.
 */
class ProjectControllerJSONTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Try accessing route 'proj/api' with a GET request and ensure it returns status 200.
     */
    public function testProjAPIRoute()
    {
        $route = '/proj/api';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }
}
