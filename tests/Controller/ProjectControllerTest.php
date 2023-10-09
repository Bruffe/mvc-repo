<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Test cases for class ProjectController.
 */
class ProjectControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Try accessing route 'proj/about' with a GET request and ensure it returns status 200.
     */
    public function testProjAboutRoute()
    {
        $route = '/proj/about';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $this->assertSelectorExists('h1', 'Om projektet');
    }

    /**
     * Try accessing route 'proj/restart-game' with a GET request and ensure it returns status 200.
     */
    public function testProjRestartGameRoute()
    {
        $route = '/proj/restart-game';
        $this->client->request('POST', $route);

        $this->client->followRedirect();

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
        
        $this->assertSelectorExists('h1', 'Starta nytt spel');
    }

    /**
     * Try accessing route 'proj/start-game' with a GET request and ensure it returns status 200.
     */
    public function testProjStartGameRoute()
    {
        $route = '/proj/start-game';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
        
        $this->assertSelectorExists('h1', 'Starta nytt spel');
    }

    /**
     * Try accessing route 'proj/init-game' with a POST request and ensure it returns status 200.
     */
    public function testProjInitGameRoute()
    {
        $formData = [
            'player-name' => 'Test',
            'hands' => '3'
        ];
        $route = '/proj/init-game';
        $this->client->request('POST', $route, $formData);

        $this->client->followRedirect();

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }

    // /**
    //  * Try accessing route 'proj/bet' with a GET request and ensure it returns status 200.
    //  */
    // public function testProjBetRoute()
    // {
    //     $route = '/proj/bet';
    //     $this->client->request('GET', $route);

    //     $exp = 200;
    //     $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

    //     $this->assertSelectorExists('h1', 'Satsa pengar');
    // }

    // /**
    //  * Try accessing route 'proj/process-bet' with a POST request and ensure it returns status 200.
    //  */
    // public function testProjProcessBetRoute()
    // {
    //     $formData = [
    //         'bet1' => '15',
    //         'bet2' => '25',
    //         'bet3' => '20'
    //     ];

    //     $route = '/proj/process-bet';
    //     $this->client->request('POST', $route, $formData);

    //     // $this->assertTrue($this->client->getResponse()->isRedirect());
    //     $this->client->followRedirect();

    //     $exp = 200;
    //     $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    // }

    // /**
    //  * Try accessing route 'proj/play-game' with a GET request and ensure it returns status 200.
    //  */
    // public function testProjPlayGameRoute()
    // {
    //     $route = '/proj/play-game';
    //     $this->client->request('GET', $route);

    //     $exp = 200;
    //     $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
        
    //     // $this->assertSelectorExists('h1', 'Starta nytt spel');
    // }
}
