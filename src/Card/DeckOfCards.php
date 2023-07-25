<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;

/**
 * Class DeckOfCards
 * 
 * This class represents a deck of cards.
 */

class DeckOfCards
{
    // private $deck = [];
    /**
     * @var Card[] $deck An array of Card objects representing the cards in the deck
     */
    public array $deck = [];

    /**
     * DeckOfCards constructor.
     * 
     * The constructor loops 52 times to create 52 different cards that fills the deck-array.
     */
    public function __construct()
    {
        foreach(range(0, 51) as $i) {
            $this->deck[] = new CardGraphic($i);
        }
    }

    /**
     * Add
     * 
     * Add a card to the deck-array.
     * @param CardGraphic $card The card to add.
     */
    public function add(CardGraphic $card): void
    {
        $this->deck[] = $card;
    }

    /**
     * Remove
     * 
     * Remove a card from the deck-array.
     * @param int $index The index of the deck-array to be removed.
     */
    public function remove(int $index): void
    {
        unset($this->deck[$index]);
        // array_splice($this->deck, $index, $index);
    }

    /**
     * Shuffle
     * 
     * Shuffle the deck-array.
     */
    public function shuffle(): void
    {
        // $this->deck = shuffle($this->deck);
        shuffle($this->deck);
    }

    /**
     * Get Indices
     * 
     * Get indices of the cards in the deck-array.
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
     * Set Cards
     * 
     * Replace the deck-array with a new array.
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
     * Get As Strings
     * 
     * Get the cards' (in the deck) string representation.
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
     * Get As String No Alt
     * 
     * Get the cards' (in the deck) string representation. Uses no "Alt code" characters, only letters.
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
