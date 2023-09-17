<?php

namespace App\Blackjack;

use App\Card\DeckOfCards;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Blackjack.
 */
class BlackjackTest extends TestCase
{
    /**
     * Construct object using arguments, and verify that the object has
     * the expected properties.
     */
    public function testBlackjackProperties()
    {
        $blackJack = new Blackjack(3, "Test");

        $expHands = 3;
        $expName = "Test";
        $expMoney = 100;

        $this->assertEquals($expHands, $blackJack->player->getHandsLeft());
        $this->assertEquals($expName, $blackJack->player->getName());
        $this->assertEquals($expMoney, $blackJack->player->getMoney());
    }

    /**
     * Construct object using arguments, call play-method and verify that
     * the player and dealer gets cards.
     */
    public function testBlackjackPlay()
    {
        $blackJack = new Blackjack(1, "Test");
        $bets = [20];
        $blackJack->player->setBets($bets);
        
        $expCards = 2;
        
        $this->assertEquals($expCards, count($blackJack->player->getHand()));
        $this->assertEquals($expCards, count($blackJack->dealer->getHand()));
        
        $blackJack->play();

        $expCards += 1;
        $this->assertEquals($expCards, count($blackJack->player->getHand()));

        // Dealer gets cards
        $expDealerCards = 3;

        $blackJack->player->setStand();
        $blackJack->play();

        $this->assertTrue($expDealerCards >= count($blackJack->dealer->getHand()) OR $blackJack->dealer->getStand());
    }

    /**
     * Construct object using arguments, and verify that the object returns
     * score in expected ranges.
     */
    public function testBlackjackGetScores()
    {
        $blackJack = new Blackjack(1, "Test");

        $expMin = 4;
        $expMax = 21;

        $this->assertTrue($expMin <= array_sum($blackJack->getPlayerScore()));
        $this->assertTrue($expMax >= array_sum($blackJack->getPlayerScore()));
    }

    /**
     * Construct object using arguments, and verify that the object returns the deck.
     */
    public function testBlackjackGetDeck()
    {
        $blackJack = new Blackjack(1, "Test");
        $deck = $blackJack->getDeck();

        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        $exp = 48;

        $this->assertEquals($exp, count($deck->deck));

        $exp = 52;

        $playerCards = count($blackJack->player->getHand());
        $dealerCards = count($blackJack->dealer->getHand());
        $totalCards = count($deck->deck) + $playerCards + $dealerCards;

        $this->assertEquals($exp, $totalCards);
    }
}
