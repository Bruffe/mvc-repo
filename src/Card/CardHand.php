<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;

class CardHand
{
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

    public function getPoints(): array
    {
        /** @var int[] $pointArray */
        $pointArray = [];
        foreach ($this->hand as $card) {
            switch ($card->getValue()) {
                case "ace":
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

        $totalPoints = count($pointArray);
        if (array_sum($pointArray) > 21) {
            for ($i = 0; $i < $totalPoints; $i++) {
                if (array_sum($pointArray) > 21 && $pointArray[$i] == 14) {
                    $pointArray[$i] = 1;
                }
            }
        }

        return $pointArray;
    }
}
