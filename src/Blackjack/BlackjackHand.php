<?php

namespace App\Blackjack;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;

class BlackjackHand extends CardHand
{
    public function __construct(DeckOfCards $deck, int $amount = 2)
    {
        $this->draw($deck, $amount);
    }
    
    public function getPoints(): array
    {
        /** @var int[] $pointArray */
        $pointArray = [];
        foreach ($this->hand as $card) {
            switch ($card->getValue()) {
                case "ace":
                    $pointArray[] = 11;
                    break;
                case "jack":
                case "queen":
                case "king":
                    $pointArray[] = 10;
                    break;
                default:
                    $pointArray[] = (int) $card->getValue();
                    break;
            }
        }

        $totalPoints = count($pointArray);
        if (array_sum($pointArray) > 21) {
            for ($i = 0; $i < $totalPoints; $i++) {
                if (array_sum($pointArray) > 21 && $pointArray[$i] == 11) {
                    $pointArray[$i] = 1;
                }
            }
        }

        return $pointArray;
    }
}
