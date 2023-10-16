<?php

namespace App\Blackjack;

use App\Card\DeckOfCards;
use App\Blackjack\BlackjackHand;

class Player extends Dealer
{
    protected int $money;
    protected int $handsLeftToPlay;
    protected int $currentHand;
    protected array $bets = [];

    private string $name;

    private array $winnings;

    public function __construct($deck, $handCount, $name, $money = 100)
    {
        parent::__construct($deck, $handCount);
        $this->handsLeftToPlay = $handCount;
        $this->currentHand = 0;

        $this->money = $money;
        $this->name = $name;
    }

    public function getWinnings(): array
    {
        return $this->winnings;
    }

    public function storeWinning($winning)
    {
        $this->winnings[] = $winning;
    }

    public function canAffordBet($bets): bool
    {
        return array_sum($bets) <= $this->money;
    }

    public function setBets($bets): void
    {
        $this->bets = $bets;
        $this->money -= array_sum($bets);
    }

    public function getBets(): array
    {
        return $this->bets;
    }

    public function getMoney(): int
    {
        return $this->money;
    }

    public function setMoney(int $value): void
    {
        $this->money = $value;
    }

    public function getName(): string
    {
        return $this->name;
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
}
