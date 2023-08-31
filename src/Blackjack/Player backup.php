<?php

namespace App\Blackjack;

// use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Blackjack\BlackjackHand;

class Player
{
    protected $isStanding = false;
    protected array $hands;
    protected int $money;
    protected int $handsLeftToPlay;

    public string $name; // test

    // public function __construct($handCount, $deck, $money = 100)
    // {
    //     var_dump("Creating Player instance with $handCount hands");
    //     $this->handsLeftToPlay = $handCount;

    //     for ($i = 1; $i <= $handCount; $i++) {
    //         // $this->hands[] = new CardHand();
    //         $this->hands[] = new BlackjackHand($deck, 2);
    //     }

    //     $this->money = $money;
    // }

    public function __construct($handCount, $deck, $money = 100)
    {
        $this->handsLeftToPlay = $handCount;
        $this->currentHand = 0;

        for ($i = 1; $i <= $handCount; $i++) {
            // $this->hands[] = new CardHand();
            $this->hands[] = new BlackjackHand($deck, 2);
        }

        $this->money = $money;

        $this->name = "Test"; // test
    }

    public function getMoney(): int
    {
        return $this->money;
    }

    public function getHand($handIndex = 0): array
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

    public function getScore($handIndex): array
    {
        return $this->hands[$handIndex]->getPoints();
    }

    public function getHandsLeft(): int
    {
        return $this->handsLeftToPlay;
    }

    public function getCurrentHand(): int
    {
        return $this->currentHand;
    }

    public function incrementCurrentHand($increment = 1): void
    {
        $this->currentHand += $increment;

        if ($this->currentHand == count($this->hands)) {
            $this->setStand();
        }
    }

    public function drawCard(DeckOfCards $deck, $handIndex): void
    {
        $card = $this->hands[$handIndex]->draw($deck, 1);
    }
}
