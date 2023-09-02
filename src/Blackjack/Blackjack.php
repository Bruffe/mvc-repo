<?php

namespace App\Blackjack;

use App\Card\DeckOfCards;
use App\Blackjack\BlackjackHand;
use App\Blackjack\Dealer;
use App\Blackjack\Player;

class Blackjack
{
    public Player $player; // eller protected?
    public Dealer $dealer;

    protected DeckOfCards $deck;

    public function __construct($handCount, $playerName)
    {
        $this->deck = new DeckOfCards();
        $this->player = new Player($this->deck, $handCount, $playerName);
        $this->dealer = new Dealer($this->deck);
    }

    public function play(): void
    {
        if ($this->player->getStand()) {
            // $this->dealer->drawCard($this->deck);
            if (array_sum($this->dealer->getScore()) > 17) {
                $this->dealer->setStand();
                // TEST
                for ($i = 0; $i < count($this->player->getHands()); $i++) {
                    $this->decideWinner($i);
                }
                // TEST
                return;
            }
            $this->dealer->drawCard($this->deck);

            $this->play();
            return;
        }

        $this->player->drawCard($this->deck, $this->player->getCurrentHand());
    }

    public function getPlayerScore($handIndex): array
    {
        return $this->player->getScore($handIndex);
    }

    public function getDealerScore(): array
    {
        return $this->dealer->getScore();
    }

    // public function payWinnings(int $handIndex)
    // {
    //     if ($this->decideWinner() == "dealer") {
    //         $this->player->storeWinning()
    //         return;
    //     }

    //     if ($this->decideWinner() == "player") {
    //         $winFactor = 2;

    //         if ($playerPoints == 21) {
    //             $winFactor = 2.5;
    //         }
    //         $this->player->setMoney($this->player->getMoney() + ($this->player->getBets()[$handIndex] * $winFactor));

    //         return "player";
    //     }

    //     if ($playerPoints == $dealerPoints) {
    //         $this->player->setMoney($this->player->getMoney() + ($this->player->getBets()[$handIndex] * 1));
    //         return "draw";
    //     }

    //     return "dealer";
    // }

    // public function decideWinner(int $handIndex): string
    // {
    //     $playerPoints = array_sum($this->getPlayerScore($handIndex));
    //     $dealerPoints = array_sum($this->getDealerScore());

    //     if (!$this->player->getStand() || !$this->dealer->getStand()) {
    //         return "";
    //     }

    //     if ($playerPoints > 21) {
    //         return "dealer";
    //     }

    //     if ($dealerPoints > 21 || $playerPoints > $dealerPoints) {
    //         return "player";
    //     }

    //     if ($playerPoints == $dealerPoints) {
    //         return "draw";
    //     }

    //     return "dealer";
    // }

    public function decideWinner(int $handIndex): string
    {
        $playerPoints = array_sum($this->getPlayerScore($handIndex));
        $dealerPoints = array_sum($this->getDealerScore());

        if (!$this->player->getStand() || !$this->dealer->getStand()) {
            return "";
        }

        if ($playerPoints > 21) {
            $this->player->storeWinning($this->player->getBets()[$handIndex] * -1);
            return "dealer";
        }

        if ($dealerPoints > 21 || $playerPoints > $dealerPoints) {
            $winFactor = 2;

            if ($playerPoints == 21) {
                $winFactor = 2.5;
            }
            $this->player->setMoney($this->player->getMoney() + ($this->player->getBets()[$handIndex] * $winFactor));
            $this->player->storeWinning($this->player->getBets()[$handIndex] * ($winFactor - 1));

            return "player";
        }

        if ($playerPoints == $dealerPoints) {
            $this->player->setMoney($this->player->getMoney() + ($this->player->getBets()[$handIndex] * 1));
            $this->player->storeWinning(0);
            return "draw";
        }

        $this->player->storeWinning($this->player->getBets()[$handIndex] * -1);
        return "dealer";
    }

}
