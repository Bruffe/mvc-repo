<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, using argument.
     */
    public function testCreateCard()
    {
        $card = new Card(0);
        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    /**
     * Construct object using arguments, and verify that the object returns
     * the correct string-representation.
     */
    public function testGetAsString()
    {
        $card = new Card(0);

        $exp = "A♠";
        $res = $card->getAsString();
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object using arguments, and verify that the object returns
     * the correct value.
     */
    public function testGetValue()
    {
        $card = new Card(0);

        $exp = "ace";
        $res = $card->getValue();
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object using arguments, and verify that the object returns
     * the correct color.
     */
    public function testGetColor()
    {
        $card = new Card(26);

        // $exp = "spades";
        $exp = "diamonds";
        $res = $card->getColor();
        $this->assertEquals($exp, $res);
    }
}
