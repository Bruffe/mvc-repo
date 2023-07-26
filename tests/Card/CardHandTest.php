<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object without argument, and verify that the object
     * is of the expected type.
     */
    public function testCreateCardHand()
    {
        $hand = new CardHand();

        $this->assertInstanceOf("\App\Card\CardHand", $hand);
    }

    /**
     * Construct object without argument, draw cards from deck object 
     * and verify that the hand contains the right amount of cards.
     */
    public function testDrawCard()
    {
        $deck = new DeckOfCards();
        $hand = new CardHand();

        $exp = 0;
        $this->assertEquals($exp, count($hand->hand));

        $hand->draw($deck, 3);

        $exp = 3;
        $this->assertEquals($exp, count($hand->hand));
    }

    /**
     * Construct object without argument, draw cards from deck object and 
     * verify that the object returns the expected cards' string-representations.
     */
    public function testGetHandCardStrings()
    {
        $deck = new DeckOfCards();
        $hand = new CardHand();

        $hand->draw($deck, 2);

        $res = $hand->getAsStringsNoAlt();

        $card1 = $hand->hand[0];
        $card2 = $hand->hand[1];
        
        $exp1 = $card1->getValue() . " of " . $card1->getColor();
        $exp2 = $card2->getValue() . " of " . $card2->getColor();

        $this->assertEquals($exp1, $res[0]);
        $this->assertEquals($exp2, $res[1]);
        $this->assertEquals([$exp1, $exp2], $res);
    }

    /**
     * Construct object without argument, draw cards from deck object and 
     * verify that the object returns a score within the expected range.
     */
    public function testGetHandScore()
    {
        $deck = new DeckOfCards();
        $hand = new CardHand();

        $cardAmount = 24;
        $hand->draw($deck, $cardAmount);

        $res = array_sum($hand->getPoints());
        
        $exp1 = 1 * $cardAmount;
        $exp2 = 14 * $cardAmount;

        $this->assertTrue($exp1 <= $res || $exp2 >= $res);
    }
}
