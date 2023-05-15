<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Game\CardGame21;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameControllerJSON extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }

    #[Route('/api/deck', name: "api_deck")]
    public function apiDeck(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "deck" => $deck->getAsStringsNoAlt()
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/deck/shuffle', name: "api_deck_shuffle", methods: ['POST'])]
    public function apiDeckShuffle(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "deck" => $deck->getAsStringsNoAlt()
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/deck/draw', name: "api_deck_draw", methods: ['POST'])]
    public function apiDeckDraw(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();

        if ($session->has("cardIndices")) {
            /** @var int[] $cardIndices */
            $cardIndices = $session->get("cardIndices");
            $deck->setCards($cardIndices);
        }

        $hand = new CardHand();
        $hand->draw($deck, 1);

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "cardsLeft" => count($deck->deck),
            "hand" => $hand->getAsStringsNoAlt(),
            "cardsDrawn" => count($hand->hand)
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/deck/draw/{amount}', name: "api_deck_draw_multiple", methods: ['POST'])]
    public function apiDeckDrawMultiple(SessionInterface $session, int $amount): Response
    {
        $deck = new DeckOfCards();

        if ($session->has("cardIndices")) {
            /** @var int[] $cardIndices */
            $cardIndices = $session->get("cardIndices");
            $deck->setCards($cardIndices);
        }

        $hand = new CardHand();
        $hand->draw($deck, $amount);

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "cardsLeft" => count($deck->deck),
            "hand" => $hand->getAsStringsNoAlt(),
            "cardsDrawn" => count($hand->hand)
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/game', name: "api_game")]
    public function apiGame(SessionInterface $session): Response
    {
        $cardGame = new CardGame21();

        if ($session->has("cardGame")) {
            $cardGame = $session->get("cardGame");
        }

        $data = [
            "playerCardValues" => $cardGame->getPlayerScore(),
            "dealerCardValues" => $cardGame->getDealerScore(),
            "playerScore" => array_sum($cardGame->getPlayerScore()),
            "dealerScore" => array_sum($cardGame->getDealerScore()),
            "winner" => $cardGame->decideWinner()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
