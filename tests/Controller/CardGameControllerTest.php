<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Test cases for class CardGameController.
 */
class CardGameControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();

        $route = '/card';
        $this->client->request('GET', $route);
    }

    /**
     * Try accessing route 'card' with a GET request and ensure it returns status 200.
     */
    public function testCardHomeRoute()
    {
        $route = '/card';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Try accessing route 'card/deck' with a GET request and ensure it returns status 200
     * and displays multiple images (cards).
     */
    public function testCardDeckRoute()
    {
        $route = '/card/deck';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $imageLink = '/img/cards/ace_of_spades.png';
        $this->assertSelectorExists("img[src='$imageLink']");
    }

    /**
     * Try accessing route 'card/deck/shuffle' with a GET request and ensure it returns status 200
     * and displays multiple images (cards).
     */
    public function testCardShuffleRoute()
    {
        $route = '/card/deck/shuffle';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $imageLink = '/img/cards/ace_of_spades.png';
        $this->assertSelectorExists("img[src='$imageLink']");

        $crawler = $this->client->getCrawler();
        $cardCount = $crawler->filter('img')->count();
        $exp = 52;
        $this->assertEquals($exp, $cardCount);
    }

    /**
     * Try accessing route 'card/deck/draw' with a GET request and ensure it returns status 200
     * and displays one image (card).
     */
    public function testCardDrawRoute()
    {
        $route = '/card/deck/draw';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->getCrawler();
        $cardCount = $crawler->filter('img')->count();
        $exp = 1;
        $this->assertEquals($exp, $cardCount);
    }

    /**
     * Try accessing route 'card/deck/draw/{num}' with a GET request and ensure it returns status 200
     * and displays one image (card). The num used for this test is 3.
     */
    public function testCardDraw3Route()
    {
        $route = '/card/deck/draw/3';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->getCrawler();
        $cardCount = $crawler->filter('img')->count();
        $exp = 3;
        $this->assertEquals($exp, $cardCount);
    }

    /**
     * Try accessing route 'game' with a GET request and ensure it returns status 200.
     */
    public function testCardGameHomeRoute()
    {
        $route = '/game';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Try accessing route 'game/doc' with a GET request and ensure it returns status 200.
     */
    public function testCardGameDocRoute()
    {
        $route = '/game/doc';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->getCrawler();
        $imageCount = $crawler->filter('img')->count();
        $exp = 1;
        $this->assertTrue($exp >= $imageCount);
    }

    /**
     * Try accessing route 'game/play' with a GET request and ensure it returns status 200.
     */
    public function testCardGamePlayRoute()
    {
        $route = '/game/play';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->getCrawler();
        $pointTextCount = $crawler->filter('h3:contains("poäng")')->count();
        $exp = 2;
        $this->assertTrue($exp >= $pointTextCount);
    }

    /**
     * Try accessing route 'game/draw' with a GET request and ensure it returns status 302 and
     * redirects to route 'game/play' with status 200.
     */
    public function testCardGameDrawRoute()
    {
        $route = '/game/draw';
        $this->client->request('GET', $route);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Try accessing route 'game/stand' with a GET request and ensure it returns status 302 and
     * redirects to route 'game/play' with status 200.
     */
    public function testCardGameStandRoute()
    {
        $route = '/game/stand';
        $this->client->request('GET', $route);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Try accessing route 'game/restart' with a GET request and ensure it returns status 302 and
     * redirects to route 'game/play' with status 200.
     */
    public function testCardGameRestartRoute()
    {
        $route = '/game/restart';
        $this->client->request('GET', $route);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
