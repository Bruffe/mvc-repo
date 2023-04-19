<?php

namespace App\Card;

class CardGraphic extends Card
{
    // protected $urlBind = "_of_";
    // protected $fileType = ".png";

    public function __construct(int $index)
    {
        parent::__construct($index);
    }

    public function getUrl(): string
    {
        $urlBind = "_of_";
        $fileType = ".png";

        $url = $this->value . $urlBind . $this->color . $fileType;
        return $url;
    }
}
