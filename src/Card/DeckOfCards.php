<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;

class DeckOfCards
{
    // private $deck = [];
    /**
     * @var Card[] $deck An array of Card objects representing the cards in the deck
     */
    public array $deck = [];

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

    /**
     * @return int[] An array of ints representing the indices of cards in the deck
     */
    public function getIndices(): array
    {
        $indices = [];
        foreach ($this->deck as $card) {
            $indices[] = $card->cardIndex;
        }
        return $indices;
    }

    /**
     * @param int[] $indices An array of ints reprensenting the indices of cards in the deck
     */
    public function setCards(array $indices): void
    {
        $newDeck = [];

        foreach($indices as $i) {
            $newDeck[] = new CardGraphic($i);
        }

        $this->deck = $newDeck;
    }

    /**
     * @return array<String>
     */
    public function getAsStrings(): array
    {
        $strings = [];

        foreach($this->deck as $card) {
            $strings[] = $card->getAsString();
        }
        return $strings;
    }

    /**
     * @return array<String>
     */
    public function getAsStringsNoAlt(): array
    {
        $strings = [];

        foreach($this->deck as $card) {
            $strings[] = $card->getValue() . " of " . $card->getColor();
        }
        return $strings;
    }
}
