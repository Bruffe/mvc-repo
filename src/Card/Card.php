<?php

namespace App\Card;

class Card
{
    protected string $value;
    protected string $color;

    public int $cardIndex;

    public function __construct(int $index)
    {
        // $this->$cardIndex = $cardIndex;
        $this->cardIndex = $index;

        // Assign colors
        $this->color = "clubs";
        if ($index < 13) {
            $this->color = "spades";
        } elseif ($index < 26) {
            $this->color = "hearts";
        } elseif ($index < 39) {
            $this->color = "diamonds";
        } 
        // else {
        //     $this->color = "clubs";
        // }

        // Assign value
        $valueList = [
            "ace",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
            "10",
            "jack",
            "queen",
            "king",
            "ace",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
            "10",
            "jack",
            "queen",
            "king",
            "ace",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
            "10",
            "jack",
            "queen",
            "king",
            "ace",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
            "10",
            "jack",
            "queen",
            "king"
        ];

        $this->value = $valueList[$index];
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getAsString(): string
    {
        $values = [
            "A♠",
            "2♠",
            "3♠",
            "4♠",
            "5♠",
            "6♠",
            "7♠",
            "8♠",
            "9♠",
            "10♠",
            "J♠",
            "Q♠",
            "K♠",
            "A♥",
            "2♥",
            "3♥",
            "4♥",
            "5♥",
            "6♥",
            "7♥",
            "8♥",
            "9♥",
            "10♥",
            "J♥",
            "Q♥",
            "K♥",
            "A♦",
            "2♦",
            "3♦",
            "4♦",
            "5♦",
            "6♦",
            "7♦",
            "8♦",
            "9♦",
            "10♦",
            "J♦",
            "Q♦",
            "K♦",
            "A♣",
            "2♣",
            "3♣",
            "4♣",
            "5♣",
            "6♣",
            "7♣",
            "8♣",
            "9♣",
            "10♣",
            "J♣",
            "Q♣",
            "K♣"
        ];
        // return $values[$this->cardIndex];
        return $values[$this->cardIndex];
    }

    public function getColor(): string
    {
        return $this->color;
    }
}
