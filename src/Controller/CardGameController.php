<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "deck" => $deck
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "deck" => $deck
        ];

        return $this->render('card/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw")]
    public function draw(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();

        if ($session->has("cardIndices")) {
            $cardIndices = $session->get("cardIndices");
            $deck->setCards($cardIndices);
        }

        if (1 > count($deck->deck)) {
            throw new \Exception("Not enough cards left in the deck!");
        }

        $hand = new CardHand();
        $hand->draw($deck, 1);

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "cardsLeft" => count($deck->deck),
            "hand" => $hand,
            // "hand" => $deck,
            "cardsDrawn" => count($hand->hand)
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "card_draw_multiple")]
    public function drawMultiple(SessionInterface $session, int $num): Response
    {
        $deck = new DeckOfCards();

        if ($session->has("cardIndices")) {
            $cardIndices = $session->get("cardIndices");
            $deck->setCards($cardIndices);
        }

        // $cardIndices = $session->get("cardIndices");

        // $deck = new DeckOfCards();
        // if ($cardIndices)
        // {
        //     $deck->setCards($cardIndices);
        // }

        if ($num > count($deck->deck)) {
            throw new \Exception("Not enough cards left in the deck!");
        }

        $hand = new CardHand();
        $hand->draw($deck, $num);

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "cardsLeft" => count($deck->deck),
            "hand" => $hand,
            // "hand" => $deck,
            "cardsDrawn" => count($hand->hand)
        ];

        return $this->render('card/draw.html.twig', $data);
    }
}
