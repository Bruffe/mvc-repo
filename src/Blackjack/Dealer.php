<?php

namespace App\Blackjack;

use App\Card\DeckOfCards;
use App\Blackjack\BlackjackHand;

class Dealer
{
    protected $isStanding = false;
    protected array $hands;

    public function __construct($deck, $handCount = 1)
    {
        $this->handsLeftToPlay = $handCount;
        $this->currentHand = 0;

        for ($i = 1; $i <= $handCount; $i++) {
            $this->hands[] = new BlackjackHand($deck, 2);
        }
    }

    public function getHand(int $handIndex = 0): array
    {
        return $this->hands[$handIndex]->hand;
    }

    public function getHands(): array
    {
        return $this->hands;
    }

    public function setStand(): void
    {
        $this->isStanding = true;
    }

    public function getStand(): bool
    {
        return $this->isStanding;
    }

    public function getScore($handIndex = 0): array
    {
        return $this->hands[$handIndex]->getPoints();
    }

    public function drawCard(DeckOfCards $deck, $handIndex = 0): void
    {
        $card = $this->hands[$handIndex]->draw($deck, 1);
    }
}
