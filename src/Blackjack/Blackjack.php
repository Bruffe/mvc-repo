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
            $this->dealer->drawCard($this->deck);
            if (array_sum($this->dealer->getScore()) > 17) {
                $this->dealer->setStand();
                return;
            }

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

    public function decideWinner(): string
    {
        $playerPoints = array_sum($this->getPlayerScore());
        $dealerPoints = array_sum($this->getDealerScore());

        if (!$this->getPlayerStand() || !$this->getDealerStand()) {
            return "";
        }

        if ($playerPoints > 21) {
            return "dealer";
        }

        if ($dealerPoints > 21 || $playerPoints > $dealerPoints) {
            return "player";
        }

        return "dealer";
    }

    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }
}
