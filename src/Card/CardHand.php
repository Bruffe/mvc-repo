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

    public function getPoints(): array
    {
        // $points = 0;
        $pointArray = [];
        foreach ($this->hand as $card) {
            // switch ($card->value) {
            switch ($card->getValue()) {
                case "ace":
                    // $points += 14
                    $pointArray[] = 14;
                    break;
                case "2":
                case "3":
                case "4":
                case "5":
                case "6":
                case "7":
                case "8":
                case "9":
                case "10":
                    // $pointArray[] = (int) $card->value;
                    $pointArray[] = (int) $card->getValue();
                    break;
                case "jack":
                    $pointArray[] = 11;
                    break;
                case "queen":
                    $pointArray[] = 12;
                    break;
                case "king":
                    $pointArray[] = 13;
                    break;
                default:
                    break;
            }
        }
        // return $points;
        return $pointArray;
    }
}
