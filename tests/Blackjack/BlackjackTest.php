<?php

namespace App\Blackjack;

use App\Card\CardGraphic;
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

        $playerHand = $blackJack->player->getHandObject();
        $dealerHand = $blackJack->dealer->getHandObject();

        $this->assertEquals($expHands, $blackJack->player->getHandsLeft());
        $this->assertEquals($expName, $blackJack->player->getName());
        $this->assertEquals($expMoney, $blackJack->player->getMoney());

        $this->assertInstanceOf("\App\Blackjack\BlackjackHand", $playerHand);
        $this->assertInstanceOf("\App\Blackjack\BlackjackHand", $dealerHand);
    }

    /**
     * Construct object using arguments, call play-method and verify that
     * the player and dealer gets cards.
     */
    public function testBlackjackPlay()
    {
        $blackJack = new Blackjack(1, "Test");
        $bets = [20];
        $this->assertTrue($blackJack->player->canAffordBet($bets));
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

        $startMoney = 100;
        $currentMoney = $blackJack->player->getMoney();
        $this->assertEquals($startMoney + $blackJack->player->getWinnings()[0], $currentMoney);

        $expMoney = 1337;
        $blackJack->player->setMoney($expMoney);
        $this->assertEquals($expMoney, $blackJack->player->getMoney());
    }

    /**
     * Construct object using arguments, call play-method and verify that
     * the player and dealer gets cards.
     */
    public function testBlackjackPlay3Hands()
    {
        $blackJack = new Blackjack(1, "Test");
        $bets = [20];
        $this->assertTrue($blackJack->player->canAffordBet($bets));
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

        $startMoney = 100;
        $currentMoney = $blackJack->player->getMoney();
        $this->assertEquals($startMoney + $blackJack->player->getWinnings()[0], $currentMoney);

        $expMoney = 1337;
        $blackJack->player->setMoney($expMoney);
        $this->assertEquals($expMoney, $blackJack->player->getMoney());
    }

    /**
     * Construct object using arguments, verify that the player
     * can increment currentHand to play the next hand and eventually
     * be standing automatically when all hands are played.
     */
    public function testBlackjackMultiHand()
    {
        $blackJack = new Blackjack(3, "Test");

        $expHands = 3;
        $this->assertEquals($expHands, count($blackJack->player->getHands()));

        $expCurrHand = 0;
        $expStand = false;
        $this->assertEquals($expCurrHand, $blackJack->player->getCurrentHand());
        $this->assertEquals($expStand, $blackJack->player->getStand());

        $blackJack->player->incrementCurrentHand();

        $expCurrHand = 1;
        $expStand = false;
        $this->assertEquals($expCurrHand, $blackJack->player->getCurrentHand());
        $this->assertEquals($expStand, $blackJack->player->getStand());

        $blackJack->player->incrementCurrentHand();

        $expCurrHand = 2;
        $expStand = false;
        $this->assertEquals($expCurrHand, $blackJack->player->getCurrentHand());
        $this->assertEquals($expStand, $blackJack->player->getStand());

        $blackJack->player->incrementCurrentHand();
        $expStand = true;
        $this->assertEquals($expStand, $blackJack->player->getStand());
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

    /**
     * Construct object using arguments, emulate a game with 3 decks and verify that
     * the object returns the expected winner on each deck.
     */
    public function testBlackjackHandleWin()
    {
        $blackJack = new Blackjack(3, "Test");

        $playerHand1 = [new CardGraphic(0), new CardGraphic(11)];
        // $playerHand2 = [new CardGraphic(1), new CardGraphic(15)];
        $playerHand2 = [new CardGraphic(7), new CardGraphic(10)];
        $playerHand3 = [new CardGraphic(4), new CardGraphic(6)];
        // $dealerHand = [new CardGraphic(14), new CardGraphic(28)];
        $dealerHand = [new CardGraphic(20), new CardGraphic(23)];

        $blackJack->player->setHand($playerHand1, 0);
        $blackJack->player->setHand($playerHand2, 1);
        $blackJack->player->setHand($playerHand3, 2);
        $blackJack->dealer->setHand($dealerHand);

        $this->assertEquals("", $blackJack->getWinner(0));

        $blackJack->player->setStand();
        $blackJack->dealer->setStand();

        $this->assertEquals(21, array_sum($blackJack->getPlayerScore(0)));
        $this->assertEquals(18, array_sum($blackJack->getPlayerScore(1)));
        $this->assertEquals(12, array_sum($blackJack->getPlayerScore(2)));
        $this->assertEquals(18, array_sum($blackJack->getDealerScore()));

        $startMoney = 100;
        $this->assertEquals($startMoney, $blackJack->player->getMoney());

        $bets = [20, 20, 20];
        $this->assertTrue($blackJack->player->canAffordBet($bets));
        $blackJack->player->setBets($bets);

        $moneyAfterBet = 40;
        $this->assertEquals($moneyAfterBet, $blackJack->player->getMoney());

        $blackJack->handleWin(0);
        $expMoney = 90;
        $this->assertEquals($expMoney, $blackJack->player->getMoney());

        $blackJack->handleWin(1);
        $expMoney = 110;
        $this->assertEquals($expMoney, $blackJack->player->getMoney());

        $blackJack->handleWin(2);
        $expMoney = 110;
        $this->assertEquals($expMoney, $blackJack->player->getMoney());
    }
}
