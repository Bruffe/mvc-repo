<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;

class DeckOfCards
{
    // private $deck = [];
    public $deck = [];

    public function __construct()
    {
        foreach(range(0, 51) as $i) {
            $this->deck[] = new CardGraphic($i);
        }
    }

    public function add(CardGraphic $card): void
    {
        $this->deck[] = $card;
    }

    public function remove(int $index): void
    {
        array_splice($this->deck, $index, $index);
    }

    // public function draw(int $amount): void
    // {
    //     // Loopa igenom antal gånger och ta bort från deck-array?
    //     foreach ($this->deck as $card) {
    //         $card->roll();
    //     }
    // }

    public function shuffle(): void
    {
        // $this->deck = shuffle($this->deck);
        shuffle($this->deck);
    }

    public function getIndices(): array
    {
        $indices = [];
        foreach ($this->deck as $card) {
            $indices[] = $card->cardIndex;
        }
        return $indices;
    }

    public function setCards(array $indices): void
    {
        $newDeck = [];

        foreach($indices as $i) {
            $newDeck[] = new CardGraphic($i);
        }

        $this->deck = $newDeck;
    }

    public function getAsStrings(): array
    {
        $strings = [];

        foreach($this->deck as $card) {
            $strings[] = $card->getAsString();
        }
        return $strings;
    }

    public function getAsStringsNoAlt(): array
    {
        $strings = [];

        foreach($this->deck as $card) {
            $strings[] = $card->getValue() . " of " . $card->getColor();
        }
        return $strings;
    }
}
