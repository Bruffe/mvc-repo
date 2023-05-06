<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;

class CardHand
{
    // private $hand = [];
    /**
     * @var Card[] $hand An array of Card objects representing the cards in the hand.
     */
    public array $hand = [];

    public function draw(DeckOfCards $deck, int $amount): void
    {
        for ($i = 0; $i < $amount; $i++) {
            $cardIndex = rand(0, count($deck->deck) - 1);
            $this->hand[] = $deck->deck[$cardIndex];
            // $deck->remove($cardIndex);
            unset($deck->deck[$cardIndex]);
            $deck->deck = array_values($deck->deck);
        }
        // $this->hand[] = $card;
    }

    /**
     * @return array<String>
     */
    public function getAsStringsNoAlt(): array
    {
        $strings = [];

        foreach($this->hand as $card) {
            $strings[] = $card->getValue() . " of " . $card->getColor();
        }
        return $strings;
    }

    // public function getUrls(): array
    // {
    //     $urls = [];
    //     foreach ($this->hand as $card) {
    //         $urls[] = $card->getUrl();
    //     }
    //     return $urls;
    // }

    // public function getString(): array
    // {
    //     $values = [];
    //     foreach ($this->hand as $card) {
    //         $values[] = $card->getAsString();
    //     }
    //     return $values;
    // }
}
