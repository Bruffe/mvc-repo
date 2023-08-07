<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class BookControllerJSON.
 */
class BookControllerJSONTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Try accessing route 'api/library/books' with a GET request and ensure it returns status 200.
     */
    public function testAPILibBooksRoute()
    {
        $route = '/api/library/books';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Try accessing route 'api/library/book/{isbn}' with a GET request and ensure it returns status 200
     * and displays information about the expected book. The ISBN for this test is 9780316457033.
     */
    public function testAPILibBookISBNRoute()
    {
        $route = '/api/library/book/9780316457033';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);
        
        $exp = "The Tower of Swallows";
        $this->assertEquals($exp, $data['title']);
        $exp = "Andrzej Sapkowski";
        $this->assertEquals($exp, $data['author']);
    }
}
