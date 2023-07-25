<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGraphic.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Construct object using argument, and verify that the object
     * is of the expected type.
     */
    public function testCreateCardGraphic()
    {
        $card = new CardGraphic(0);
        $this->assertInstanceOf("\App\Card\CardGraphic", $card);
    }

    /**
     * Construct object using argument, and verify that the object
     * returns the expected filename.
     */
    public function testGetUrl()
    {
        $card = new CardGraphic(0);

        $exp = "ace_of_spades.png";
        $res = $card->getUrl();
        $this->assertEquals($exp, $res);
    }
}
