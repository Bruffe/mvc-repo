<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class CardGameControllerJSON.
 */
class CardGameControllerJSONTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Try accessing route 'api' with a GET request and ensure it returns status 200.
     */
    public function testAPIRoute()
    {
        $route = '/api';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Try accessing route 'api/deck' with a GET request and ensure it returns status 200
     * and returns a card deck as JSON. Then access route 'api/deck/shuffle' with a POST request
     * to shuffle the deck and make sure it's shuffled.
     */
    public function testAPIDeckAndShuffleRoutes()
    {
        $route = '/api/deck';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);
        
        $exp = "ace of spades";
        $this->assertContains($exp, $data['deck']);

        // Shuffle and compare decks
        $deck = $data['deck'];
        $route = '/api/deck/shuffle';
        $this->client->request('POST', $route);

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertContains($exp, $data['deck']);
        $this->assertNotEquals($deck, $data['deck']);
    }

    /**
     * Try accessing route 'api/deck/draw' with a POST request and ensure it returns status 200.
     * Also try accessing route 'api/deck/draw/{amount}' with a POST request and ensure they both
     * return a hand of the expected amount of cards, as JSON. The amount variable in this test is 3.
     */
    public function testAPIDeckDrawRoutes()
    {
        $route = '/api/deck/draw';
        $this->client->request('POST', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $expCardsInDeck = 52;
        $exp = 1;
        $expCardsInDeck = $expCardsInDeck - $exp;

        $this->assertCount($exp, $data['hand']);
        $this->assertEquals($exp, $data['cardsDrawn']);
        $this->assertEquals($expCardsInDeck, $data['cardsLeft']);

        // Draw 3 cards
        $route = '/api/deck/draw/3';
        $this->client->request('POST', $route);

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $exp = 3;
        $expCardsInDeck = $expCardsInDeck - $exp;
        $this->assertCount($exp, $data['hand']);
        $this->assertEquals($exp, $data['cardsDrawn']);
        $this->assertEquals($expCardsInDeck, $data['cardsLeft']);
    }

    /**
     * Try accessing route 'api/game' with a POST request and ensure it returns status 200
     * and returns some type of data as JSON.
     */
    public function testAPIGameRoute()
    {
        $route = '/api/game';
        $this->client->request('GET', $route);

        $exp = 200;
        $this->assertEquals($exp, $this->client->getResponse()->getStatusCode());

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $exp = 0;
        $this->assertIsArray($data);
        $this->assertArrayHasKey('playerCardValues', $data);
        $this->assertArrayHasKey('dealerCardValues', $data);
        $this->assertEquals($exp, $data['playerScore']);
        $this->assertEquals($exp, $data['dealerScore']);
    }
}
