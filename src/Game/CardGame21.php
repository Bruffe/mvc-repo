<?php

namespace App\Game;

use App\Card\CardHand;
use App\Card\DeckOfCards;

class CardGame21
{
    protected bool $playerStand;
    protected bool $dealerStand;

    protected CardHand $playerHand;
    protected CardHand $dealerHand;

    protected DeckOfCards $deck;

    public function __construct()
    {
        $this->playerStand = false;
        $this->dealerStand = false;
        $this->playerHand = new CardHand();
        $this->dealerHand = new CardHand();
        $this->deck = new DeckOfCards();
    }

    public function play(): void
    {
        if ($this->playerStand) {
            // dealers turn
            $this->dealerDraw();
            return;
        }

        // players turn
        $this->playerDraw();
    }

    public function playerDraw(): void
    {
        $this->playerHand->draw($this->deck, 1);
    }

    public function dealerDraw(): void
    {
        // recursion
        $this->dealerHand->draw($this->deck, 1);
        if (array_sum($this->getDealerScore()) > 13) {
            $this->setDealerStand();
            return;
        }

        $this->dealerDraw();
    }

    public function getPlayerHand(): array
    {
        return $this->playerHand->hand;
    }

    public function getDealerHand(): array
    {
        return $this->dealerHand->hand;
    }

    public function setPlayerStand(): void
    {
        $this->playerStand = true;
    }

    public function setDealerStand(): void
    {
        $this->dealerStand = true;
    }

    public function getPlayerStand(): bool
    {
        return $this->playerStand;
    }

    public function getDealerStand(): bool
    {
        return $this->dealerStand;
    }

    public function getPlayerScore(): array
    {
        return $this->playerHand->getPoints();
    }

    public function getDealerScore(): array
    {
        return $this->dealerHand->getPoints();
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
}
