<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class BookController.
 */
class BookControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Try accessing route 'library/show' with a GET request and ensure it returns status 200
     * and displays information about at least one expected book.
     */
    public function testLibShowRoute()
    {
        $route = '/library/show';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $this->assertSelectorExists('td', 'The Tower of Swallows');
        $this->assertSelectorExists('td', 'Andrzej Sapkowski');
    }

    /**
     * Try accessing route 'library/show/{id}' with a GET request and ensure it returns status 200
     * and displays information about the expected book. The ID in this test is 2.
     */
    public function testLibShowOneRoute()
    {
        $route = '/library/show/2';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
        
        $this->assertSelectorExists('td', 'The Tower of Swallows');
        $this->assertSelectorExists('td', 'Andrzej Sapkowski');
    }

    /**
     * Try accessing route 'library/create' with a GET request and ensure it returns status 200
     * and displays a form that can be filled.
     */
    public function testLibCreateFormRoute()
    {
        $route = '/library/create';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $this->assertSelectorExists('form');
        $this->assertSelectorExists('label', 'Titel');
        $this->assertSelectorExists('label', 'Författare');
        $this->assertSelectorExists('input', 'Lägg till');
    }

    /**
     * Try accessing route 'library/update' with a GET request and ensure it returns status 200
     * and displays a form that can be filled.
     */
    public function testLibUpdateFormRoute()
    {
        $route = '/library/update/9';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $this->assertSelectorExists('form');
        $this->assertSelectorExists('label', 'Titel');
        $this->assertSelectorExists('label', 'Författare');
        $this->assertSelectorExists('input', 'Spara ändringar');
    }

    /**
     * Try accessing route 'library/delete' with a GET request and ensure it returns status 200
     * and displays a form that can be filled.
     */
    public function testLibDeleteFormRoute()
    {
        $route = '/library/delete/9';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $this->assertSelectorExists('form');
        $this->assertSelectorExists('label', 'Titel');
        $this->assertSelectorExists('label', 'Författare');
        $this->assertSelectorExists('input', 'Ta bort');
    }
}
