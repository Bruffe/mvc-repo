<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object without argument, and verify that the object
     * is of the expected type.
     */
    public function testCreateDeckOfCards()
    {
        $deck = new DeckOfCards();

        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
    }

    /**
     * Construct object and make sure the deck contains the right amount
     * of cards when created, also make sure cards can be removed and
     * added again.
     */
    public function testDeckCountAfterRemovingAndAdding()
    {
        $deck = new DeckOfCards();

        $exp = 52;
        $this->assertEquals($exp, count($deck->deck));

        $card = $deck->deck[0];
        $deck->remove(0);

        $exp = 51;
        $this->assertEquals($exp, count($deck->deck));

        $deck->add($card);
        $exp = 52;
        $this->assertEquals($exp, count($deck->deck));
    }

    /**
     * Construct object and make sure the deck can be shuffled.
     */
    public function testDeckShuffle()
    {
        $deck = new DeckOfCards();

        $cards = $deck->deck;
        $indices = $deck->getIndices();

        $exp = 52;
        $this->assertEquals($exp, count($deck->deck));

        $deck->shuffle();
        $this->assertNotEquals($cards, $deck->deck);
        $this->assertNotEquals($indices, $deck->getIndices());

        $this->assertEquals($exp, count($deck->deck));
    }

    /**
     * Construct object and make sure the deck is replaceable/updateable with
     * the setCards-function.
     */
    public function testDeckSetCards()
    {
        $deck = new DeckOfCards();

        $cards = $deck->deck;
        $indices = [5, 4, 3, 2, 1, 0];
        $deck->setCards($indices);

        $this->assertNotEquals($cards, $deck->deck);
    }

    /**
     * Construct object and make sure the methods getAsStrings and
     * getAsStringsNoAlt returns the expected values.
     */
    public function testDeckGetCardsAsStrings()
    {
        $deck = new DeckOfCards();

        $cards = $deck->deck;
        $indices = [3, 2, 1, 0];
        $deck->setCards($indices);

        $exp = ["4♠", "3♠", "2♠", "A♠"];
        $this->assertEquals($exp, $deck->getAsStrings());

        $exp = ["4 of spades", "3 of spades", "2 of spades", "ace of spades"];
        $this->assertEquals($exp, $deck->getAsStringsNoAlt());
    }
}
